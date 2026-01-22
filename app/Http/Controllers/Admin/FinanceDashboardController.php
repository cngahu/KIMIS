<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentLedger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceDashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from
            ? Carbon::parse($request->from)->startOfDay()
            : null;

        $to = $request->to
            ? Carbon::parse($request->to)->endOfDay()
            : null;

        // -------------------------------------------------
        // BASE QUERY
        // -------------------------------------------------
        $ledger = StudentLedger::query()
            ->when($from, fn($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn($q) => $q->where('created_at', '<=', $to));

        // -------------------------------------------------
        // TOTALS
        // -------------------------------------------------
        $totalDebits = (clone $ledger)
            ->where('entry_type', 'debit')
            ->sum('amount');

        $totalCredits = (clone $ledger)
            ->where('entry_type', 'credit')
            ->sum('amount');

        $outstanding = $totalDebits - $totalCredits;

        // -------------------------------------------------
        // TODAY SNAPSHOT
        // -------------------------------------------------
        $today = Carbon::today();

        $todayDebits = StudentLedger::whereDate('created_at', $today)
            ->where('entry_type', 'debit')
            ->sum('amount');

        $todayCredits = StudentLedger::whereDate('created_at', $today)
            ->where('entry_type', 'credit')
            ->sum('amount');

        // -------------------------------------------------
        // CATEGORY BREAKDOWN
        // -------------------------------------------------
        $categoryBreakdown = StudentLedger::select(
            'category',
            DB::raw("SUM(CASE WHEN entry_type='debit' THEN amount ELSE 0 END) as debits"),
            DB::raw("SUM(CASE WHEN entry_type='credit' THEN amount ELSE 0 END) as credits")
        )
            ->when($from, fn($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn($q) => $q->where('created_at', '<=', $to))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        // -------------------------------------------------
        // DAILY AGGREGATES (FOR TRENDS)
        // -------------------------------------------------
        $daily = StudentLedger::select(
            DB::raw('DATE(created_at) as day'),
            DB::raw("SUM(CASE WHEN entry_type='debit' THEN amount ELSE 0 END) as debits"),
            DB::raw("SUM(CASE WHEN entry_type='credit' THEN amount ELSE 0 END) as credits")
        )
            ->when($from, fn($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn($q) => $q->where('created_at', '<=', $to))
            ->groupBy('day')
            ->orderByDesc('day')
            ->limit(14)
            ->get();

        return view('finance.dashboard.index', compact(
            'totalDebits',
            'totalCredits',
            'outstanding',
            'todayDebits',
            'todayCredits',
            'categoryBreakdown',
            'daily',
            'from',
            'to'
        ));
    }
}

