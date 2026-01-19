<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Masterdata;
use App\Models\StudentLedger;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class OpeningBalanceLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::transaction(function () {

            Masterdata::whereNotNull('balance')
                ->where('balance', '>', 0)
                ->chunkById(200, function ($records) {

                    foreach ($records as $master) {

                        $exists = StudentLedger::where('masterdata_id', $master->id)
                            ->where('category', 'opening_balance')
                            ->exists();

                        if ($exists) {
                            continue; // safety
                        }

                        StudentLedger::create([
                            'masterdata_id' => $master->id,

                            'entry_type'    => 'debit',
                            'category'      => 'opening_balance',
                            'amount'        => $master->balance,

                            'provisional'   => true,

                            'source'        => 'legacy_masterdata',
                            'description'   => 'Opening balance migrated from legacy system',

                            'created_by'    => null, // system
                        ]);
                    }
                });
        });
    }
}
