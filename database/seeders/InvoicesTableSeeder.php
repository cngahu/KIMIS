<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Invoice;

use Illuminate\Support\Str;
use Carbon\Carbon;
class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $applications = Application::all();

        $counter = 10001; // sequential invoice start

        foreach ($applications as $app) {

            // realistic created & paid times
            $invoiceCreated = $app->created_at->copy()->addHours(rand(1, 5));
            $invoicePaid    = $invoiceCreated->copy()->addHours(rand(1, 12));

            Invoice::create([
                'application_id'   => $app->id,
                'invoice_number'   => 'INV-' . date('Y') . '-' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'amount'           => 1000.00,
                'status'           => 'paid',
                'gateway_reference'=> 'SIM-' . strtoupper(Str::random(10)),
                'paid_at'          => $invoicePaid,
                'metadata'         => json_encode(['note' => 'Simulated invoice payment']),
                'created_at'       => $invoiceCreated,
                'updated_at'       => $invoicePaid,
            ]);
        }
    }
}
