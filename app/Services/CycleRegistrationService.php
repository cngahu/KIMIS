<?php

namespace App\Services;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\StudentCycleRegistration;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\CourseStageFee;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CycleRegistrationService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Register student for a cycle and generate invoice
     */
    public function registerForCycle(
        Student $student,
        Enrollment $enrollment,
        int $cycleYear,
        string $cycleTerm
    ): StudentCycleRegistration {

        return DB::transaction(function () use ($student, $enrollment, $cycleYear, $cycleTerm) {

            // -------------------------------------------------
            // 1. Prevent duplicate registration
            // -------------------------------------------------
            if (StudentCycleRegistration::where('student_id', $student->id)
                ->where('cycle_year', $cycleYear)
                ->where('cycle_term', $cycleTerm)
                ->exists()) {
                throw new \Exception('Already registered for this cycle.');
            }

            // -------------------------------------------------
            // 2. Resolve current stage from enrollment
            // -------------------------------------------------
            $stageId = $enrollment->course_stage_id;

            if (!$stageId) {
                throw new \Exception('Student has no current stage.');
            }

            // -------------------------------------------------
            // 3. Create cycle registration (PENDING)
            // -------------------------------------------------
            $registration = StudentCycleRegistration::create([
                'student_id'      => $student->id,
                'enrollment_id'   => $enrollment->id,
                'course_stage_id' => $stageId,
                'cycle_year'      => $cycleYear,
                'cycle_term'      => $cycleTerm,
                'status'          => 'pending_payment',
                'registered_at'   => now(),
            ]);

            // -------------------------------------------------
            // 4. Generate invoice
            // -------------------------------------------------
            $invoice = $this->generateInvoice(
                $student,
                $enrollment,
                $registration
            );

            // -------------------------------------------------
            // 5. Link invoice to registration
            // -------------------------------------------------
            $registration->update([
                'invoice_id' => $invoice->id
            ]);

            // -------------------------------------------------
            // 6. Audit
            // -------------------------------------------------
            $this->audit->log('cycle_registered', $registration);

            return $registration;
        });
    }

    /**
     * Generate course fee invoice for a cycle
     */
    protected function generateInvoice(
        Student $student,
        Enrollment $enrollment,
        StudentCycleRegistration $registration
    ): Invoice {

        // -------------------------------------------------
        // Detect first course invoice
        // -------------------------------------------------
        $hasCourseInvoice = Invoice::where('user_id', $student->user_id)
            ->where('category', 'course_fee')
            ->exists();

        $items = [];
        $total = 0;

        // -------------------------------------------------
        // Opening balance (only once)
        // -------------------------------------------------
        if (!$hasCourseInvoice) {
            $openingBalance = $student->openingBalance?->amount ?? 0;

            if ($openingBalance > 0) {
                $items[] = [
                    'item_name'    => 'Opening Balance',
                    'unit_amount'  => $openingBalance,
                    'quantity'     => 1,
                    'total_amount' => $openingBalance,
                    'metadata'     => ['type' => 'opening_balance'],
                ];
                $total += $openingBalance;
            }
        }

        // -------------------------------------------------
        // Stage fee
        // -------------------------------------------------
        $stageFee = CourseStageFee::where('course_id', $enrollment->course_id)
            ->where('course_stage_id', $registration->course_stage_id)
            ->where('is_billable', 1)
            ->orderByDesc('effective_from')
            ->first();

        if (!$stageFee) {
            throw new \Exception('No fee defined for this stage.');
        }

        $items[] = [
            'item_name'    => "Tuition Fee – {$registration->stage->code}",
            'unit_amount'  => $stageFee->amount,
            'quantity'     => 1,
            'total_amount' => $stageFee->amount,
            'metadata'     => [
                'course_stage_id' => $registration->course_stage_id,
                'cycle' => "{$registration->cycle_term} {$registration->cycle_year}",
            ],
        ];
        $total += $stageFee->amount;

        // -------------------------------------------------
        // Create invoice
        // -------------------------------------------------
        $invoice = Invoice::create([
            'billable_type' => StudentCycleRegistration::class,
            'billable_id'   => $registration->id,

            'user_id'       => $student->user_id,
            'course_id'     => $enrollment->course_id,
            'category' => 'tuition_fee',


            'invoice_number'=> $this->generateInvoiceNumber(),
            'amount'        => $total,
            'status'        => 'pending',
            'metadata'      => [
                'student_id'    => $student->id,
                'enrollment_id' => $enrollment->id,
                'cycle_year'    => $registration->cycle_year,
                'cycle_term'    => $registration->cycle_term,
            ],
        ]);

        // -------------------------------------------------
        // Create invoice items
        // -------------------------------------------------
        foreach ($items as $item) {
            InvoiceItem::create(array_merge($item, [
                'invoice_id' => $invoice->id,
                'user_id'    => $student->user_id,
            ]));
        }

        $this->audit->log('cycle_invoice_created', $invoice);

        return $invoice;
    }

    protected function generateInvoiceNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
