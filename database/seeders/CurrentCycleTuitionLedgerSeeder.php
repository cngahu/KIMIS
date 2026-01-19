<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Masterdata;
use App\Models\StudentLedger;
use App\Models\CohortStageTimeline;
use App\Models\CourseStageFee;
use Illuminate\Support\Facades\DB;
class CurrentCycleTuitionLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cycle = $this->currentCycle();

        DB::transaction(function () use ($cycle) {

            Masterdata::whereNotNull('course_id')
                ->whereNotNull('cohort_id_provisional')
                ->chunkById(200, function ($records) use ($cycle) {

                    foreach ($records as $master) {

                        // ----------------------------------
                        // Safety: prevent duplicate seeding
                        // ----------------------------------
                        $exists = StudentLedger::where('masterdata_id', $master->id)
                            ->where('category', 'tuition_fee')
                            ->where('cycle_term', $cycle['term'])
                            ->where('cycle_year', $cycle['year'])
                            ->exists();

                        if ($exists) {
                            continue;
                        }

                        // ----------------------------------
                        // Resolve current stage from timeline
                        // ----------------------------------
                        $timeline = CohortStageTimeline::where('course_cohort_id', $master->cohort_id_provisional)
                            ->whereDate('start_date', '<=', now())
                            ->whereDate('end_date', '>=', now())
                            ->first();

                        if (! $timeline) {
                            continue; // no active stage → do not bill
                        }

                        $stageId = $timeline->course_stage_id;

                        // ----------------------------------
                        // Resolve applicable stage fee
                        // ----------------------------------
                        $stageFee = CourseStageFee::where('course_id', $master->course_id)
                            ->where('course_stage_id', $stageId)
                            ->where('is_billable', 1)
                            ->whereDate('effective_from', '<=', now())
                            ->where(function ($q) {
                                $q->whereNull('effective_to')
                                    ->orWhereDate('effective_to', '>=', now());
                            })
                            ->orderByDesc('effective_from')
                            ->first();

                        if (! $stageFee || $stageFee->amount <= 0) {
                            continue; // nothing to bill
                        }

                        // ----------------------------------
                        // Create ledger entry
                        // ----------------------------------
                        StudentLedger::create([
                            'masterdata_id'   => $master->id,

                            'entry_type'      => 'debit',
                            'category'        => 'tuition_fee',
                            'amount'          => $stageFee->amount,

                            'provisional'     => true,

                            'cycle_term'      => $cycle['term'],
                            'cycle_year'      => $cycle['year'],

                            'course_id'       => $master->course_id,
                            'course_stage_id' => $stageId,

                            'source'          => 'legacy_projection',
                            'description'     => "Tuition fee – {$timeline->stage->code} – {$cycle['term']} {$cycle['year']}",

                            'created_by'      => null,
                        ]);
                    }
                });
        });
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
