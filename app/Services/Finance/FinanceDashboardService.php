<?php

namespace App\Services\Finance;

use App\Models\StudentLedger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinanceDashboardService
{
    public function build(): array
    {
        $today = Carbon::today();

        return [
            'today'        => $this->todayStats($today),
            'month'        => $this->monthStats(),
            'cumulative'   => $this->cumulativeStats(),
            'by_channel'   => $this->creditsByChannel($today),
            'by_category'  => $this->debitsByCategory($today),
        ];
    }

    protected function todayStats(Carbon $date): array
    {
        return [
            'debits_amount' => StudentLedger::whereDate('created_at', $date)
                ->where('entry_type', 'debit')
                ->sum('amount'),

            'credits_amount' => StudentLedger::whereDate('created_at', $date)
                ->where('entry_type', 'credit')
                ->sum('amount'),

            'debits_count' => StudentLedger::whereDate('created_at', $date)
                ->where('entry_type', 'debit')
                ->count(),

            'credits_count' => StudentLedger::whereDate('created_at', $date)
                ->where('entry_type', 'credit')
                ->count(),
        ];
    }

    protected function monthStats(): array
    {
        return [
            'debits' => StudentLedger::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('entry_type', 'debit')
                ->sum('amount'),

            'credits' => StudentLedger::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('entry_type', 'credit')
                ->sum('amount'),
        ];
    }

    protected function cumulativeStats(): array
    {
        $debits = StudentLedger::where('entry_type', 'debit')->sum('amount');
        $credits = StudentLedger::where('entry_type', 'credit')->sum('amount');

        return [
            'total_debits'   => $debits,
            'total_credits'  => $credits,
            'outstanding'    => $debits - $credits,
        ];
    }

    protected function creditsByChannel(Carbon $date)
    {
        return StudentLedger::select('source', DB::raw('SUM(amount) as total'))
            ->whereDate('created_at', $date)
            ->where('entry_type', 'credit')
            ->groupBy('source')
            ->get();
    }

    protected function debitsByCategory(Carbon $date)
    {
        return StudentLedger::select('category', DB::raw('SUM(amount) as total'))
            ->whereDate('created_at', $date)
            ->where('entry_type', 'debit')
            ->groupBy('category')
            ->get();
    }
}
