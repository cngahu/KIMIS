<?php

namespace App\Services;

use App\Models\CohortStageTimeline;
use App\Models\CourseStageFee;
use App\Models\Masterdata;
use App\Models\StudentLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterdataLedgerService0
{
    public function initialize(Masterdata $master): void
    {
        DB::transaction(function () use ($master) {

            $this->postOpeningBalance($master);
            $this->postCurrentCycleTuition($master);
        });
    }

    protected function postOpeningBalance(Masterdata $master): void
    {
        if (($master->balance ?? 0) <= 0) {
            return;
        }

        $exists = StudentLedger::where('masterdata_id', $master->id)
            ->where('category', 'opening_balance')
            ->exists();

        if ($exists) {
            return;
        }

        StudentLedger::create([
            'masterdata_id' => $master->id,
            'entry_type'    => 'debit',
            'category'      => 'opening_balance',
            'amount'        => $master->balance,
            'provisional'   => true,
            'source'        => 'legacy_masterdata',
            'description'   => 'Opening balance captured on masterdata creation',
        ]);
    }

    protected function postCurrentCycleTuition(Masterdata $master): void
    {
        if (! $master->course_id || ! $master->cohort_id_provisional) {
            return;
        }

        $cycle = $this->currentCycle();

        $exists = StudentLedger::where('masterdata_id', $master->id)
            ->where('category', 'tuition_fee')
            ->where('cycle_term', $cycle['term'])
            ->where('cycle_year', $cycle['year'])
            ->exists();

        if ($exists) {
            return;
        }

        $timeline = CohortStageTimeline::where('course_cohort_id', $master->cohort_id_provisional)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (! $timeline) {
            return;
        }

        $stageFee = CourseStageFee::where('course_id', $master->course_id)
            ->where('course_stage_id', $timeline->course_stage_id)
            ->where('is_billable', 1)
            ->orderByDesc('effective_from')
            ->first();

        if (! $stageFee || $stageFee->amount <= 0) {
            return;
        }

        StudentLedger::create([
            'masterdata_id'   => $master->id,
            'entry_type'      => 'debit',
            'category'        => 'tuition_fee',
            'amount'          => $stageFee->amount,
            'provisional'     => true,
            'cycle_term'      => $cycle['term'],
            'cycle_year'      => $cycle['year'],
            'course_id'       => $master->course_id,
            'course_stage_id' => $timeline->course_stage_id,
            'source'          => 'legacy_projection',
            'description'     => "Tuition fee – {$timeline->stage->code} – {$cycle['term']} {$cycle['year']}",
        ]);
    }

    protected function currentCycle(): array
    {
        $month = now()->month;

        return match (true) {
            $month <= 4 => ['term' => 'Jan', 'year' => now()->year],
            $month <= 8 => ['term' => 'May', 'year' => now()->year],
            default     => ['term' => 'Sep', 'year' => now()->year],
        };
    }
}

class MasterdataLedgerService
{
    public function initialize(Masterdata $master): void
    {
        Log::info('Initializing ledger for masterdata', [
            'masterdata_id' => $master->id,
        ]);

        DB::transaction(function () use ($master) {
            $this->postOpeningBalance($master);
            $this->postCurrentCycleTuition($master);
        });

        Log::info('Ledger initialization completed', [
            'masterdata_id' => $master->id,
        ]);
    }

    /**
     * ---------------------------------------------------------
     * OPENING BALANCE
     * ---------------------------------------------------------
     */
    protected function postOpeningBalance(Masterdata $master): void
    {
        if (($master->balance ?? 0) <= 0) {
            return;
        }

        $exists = StudentLedger::where('ledger_owner_type', Masterdata::class)
            ->where('ledger_owner_id', $master->id)
            ->where('category', 'opening_balance')
            ->exists();

        if ($exists) {
            return;
        }

        StudentLedger::create([
            // ---------------------------------
            // LEDGER OWNER (AUTHORITATIVE)
            // ---------------------------------
            'ledger_owner_type' => Masterdata::class,
            'ledger_owner_id'   => $master->id,

            // ---------------------------------
            // LEGACY LINKS
            // ---------------------------------
            'masterdata_id' => $master->id,
            'student_id'    => null,
            'enrollment_id' => null,

            // ---------------------------------
            // LEDGER ENTRY
            // ---------------------------------
            'entry_type'  => 'debit',
            'category'    => 'opening_balance',
            'amount'      => $master->balance,
            'provisional' => true,

            // ---------------------------------
            // METADATA
            // ---------------------------------
            'source'      => 'legacy_masterdata',
            'description' => 'Opening balance captured on masterdata creation',
            'created_by'  => null,
        ]);
    }

    /**
     * ---------------------------------------------------------
     * CURRENT CYCLE TUITION
     * ---------------------------------------------------------
     */
    protected function postCurrentCycleTuition(Masterdata $master): void
    {
        if (! $master->course_id || ! $master->cohort_id_provisional) {
            return;
        }

        $cycle = $this->currentCycle();

        $exists = StudentLedger::where('ledger_owner_type', Masterdata::class)
            ->where('ledger_owner_id', $master->id)
            ->where('category', 'tuition_fee')
            ->where('cycle_term', $cycle['term'])
            ->where('cycle_year', $cycle['year'])
            ->exists();

        if ($exists) {
            return;
        }

        // Resolve active stage
        $timeline = CohortStageTimeline::where('course_cohort_id', $master->cohort_id_provisional)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (! $timeline) {
            return;
        }

        // Resolve fee
        $stageFee = CourseStageFee::where('course_id', $master->course_id)
            ->where('course_stage_id', $timeline->course_stage_id)
            ->where('is_billable', 1)
            ->whereDate('effective_from', '<=', now())
            ->where(function ($q) {
                $q->whereNull('effective_to')
                    ->orWhereDate('effective_to', '>=', now());
            })
            ->orderByDesc('effective_from')
            ->first();

        if (! $stageFee || $stageFee->amount <= 0) {
            return;
        }

        StudentLedger::create([
            // ---------------------------------
            // LEDGER OWNER (AUTHORITATIVE)
            // ---------------------------------
            'ledger_owner_type' => Masterdata::class,
            'ledger_owner_id'   => $master->id,

            // ---------------------------------
            // LEGACY LINKS
            // ---------------------------------
            'masterdata_id'   => $master->id,
            'student_id'      => null,
            'enrollment_id'   => null,

            // ---------------------------------
            // LEDGER ENTRY
            // ---------------------------------
            'entry_type'      => 'debit',
            'category'        => 'tuition_fee',
            'amount'          => $stageFee->amount,
            'provisional'     => true,

            // ---------------------------------
            // CONTEXT
            // ---------------------------------
            'cycle_term'      => $cycle['term'],
            'cycle_year'      => $cycle['year'],
            'course_id'       => $master->course_id,
            'course_stage_id' => $timeline->course_stage_id,

            // ---------------------------------
            // METADATA
            // ---------------------------------
            'source'          => 'legacy_masterdata',
            'description'     =>
                "Tuition fee – {$timeline->stage->code} – {$cycle['term']} {$cycle['year']}",

            'created_by'      => null,
        ]);
    }

    protected function currentCycle(): array
    {
        $month = now()->month;

        return match (true) {
            $month <= 4 => ['term' => 'Jan', 'year' => now()->year],
            $month <= 8 => ['term' => 'May', 'year' => now()->year],
            default     => ['term' => 'Sep', 'year' => now()->year],
        };
    }
}
