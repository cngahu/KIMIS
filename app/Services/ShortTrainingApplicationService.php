<?php

namespace App\Services;
use App\Models\Course;
use App\Models\ShortTrainingApplication;
use App\Models\ShortTraining;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShortTrainingApplicationService
{
    public function createShortApplication($training, array $validated, $request)
    {
        return DB::transaction(function () use ($training, $validated, $request) {

            $participants = $validated['applicants'];
            $participantCount = count($participants);
            $amountPerPerson = $training->cost ?? 0;
            $totalAmount = $amountPerPerson * $participantCount;

            // -----------------------------------------
            // 1. CREATE PARENT SHORT COURSE APPLICATION
            // -----------------------------------------
            $application = ShortTrainingApplication::create([
                'training_id' => $training->id,
                'financier'   => $validated['financier'],
                'reference'   => $this->generateReference(),

                // Employer details if applicable
                'employer_name'            => $validated['employer_name'] ?? null,
                'employer_contact_person'  => $validated['employer_contact_person'] ?? null,
                'employer_phone'           => $validated['employer_phone'] ?? null,
                'employer_email'           => $validated['employer_email'] ?? null,
                'employer_postal_address'  => $validated['employer_postal_address'] ?? null,
                'employer_postal_code_id'  => $validated['employer_postal_code_id'] ?? null,
                'employer_town'            => $validated['employer_town'] ?? null,
                'employer_county_id'       => $validated['employer_county_id'] ?? null,

                'total_participants' => $participantCount,
                'status' => 'pending_payment',
                'payment_status' => 'pending',

                'metadata' => [
                    'amount_per_person' => $amountPerPerson,
                    'total_amount'      => $totalAmount,
                ],
            ]);

            // -----------------------------------------
            // 2. SAVE PARTICIPANTS TO short_trainings
            // -----------------------------------------
            $uploadDisk = 'public';

            foreach ($participants as $index => $p) {

                $nationalIdPath = null;
                $nationalIdOriginal = null;

                if ($request->hasFile("applicants.$index.national_id")) {
                    $file = $request->file("applicants.$index.national_id");
                    $nationalIdOriginal = $file->getClientOriginalName();
                    $nationalIdPath = $file->store("short_trainings/national_ids", $uploadDisk);
                }

                ShortTraining::create([
                    'application_id'          => $application->id,
                    'training_id'             => $training->id,
                    'full_name'               => $p['full_name'],
                    'id_no'                   => $p['id_no'] ?? null,
                    'phone'                   => $p['phone'],
                    'email'                   => $p['email'] ?? null,

                    'national_id_path'        => $nationalIdPath,
                    'national_id_original_name' => $nationalIdOriginal,

                    'home_county_id'          => $p['home_county_id'],
                    'current_county_id'       => $p['current_county_id'],
                    'current_subcounty_id'    => $p['current_subcounty_id'],
                    'postal_address'          => $p['postal_address'],
                    'postal_code_id'          => $p['postal_code_id'],
                    'co'                      => $p['co'] ?? null,
                    'town'                    => $p['town'] ?? null,
                ]);
            }

            // -----------------------------------------
            // 3. RETURN APPLICATION FOR PAYMENT ROUTE
            // Invoice creation happens in the next step.
            // -----------------------------------------
            $invoice = app(\App\Services\PaymentService::class)
                ->generateShortCourseInvoice($application);

            // ----------------------------------------------------
            // 4. RETURN INVOICE TO CONTROLLER
            // ----------------------------------------------------
            return $invoice;
        });
    }

    protected function generateReference()
    {
        return 'STAPP-' . strtoupper(Str::random(8));
    }
}
