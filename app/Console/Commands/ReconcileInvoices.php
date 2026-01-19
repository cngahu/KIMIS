<?php

namespace App\Console\Commands;

use App\Services\Finance\InvoiceReconciliationService;
use Illuminate\Console\Command;

class ReconcileInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:reconcile-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
//    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
//    public function handle()
//    {
//        //
//    }

    protected $signature = 'finance:reconcile-invoices {--dry-run}';
    protected $description = 'Reconcile invoices into the student ledger';
    public function handle(InvoiceReconciliationService $service)
    {
        $dryRun = $this->option('dry-run');

        $summary = $service->reconcile($dryRun);

        $this->info('Reconciliation complete');
        $this->table(
            array_keys($summary),
            [array_values($summary)]
        );
    }


}
