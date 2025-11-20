<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class RegistrarDashboardController extends Controller
{
    //
    public function index()
    {
        $total          = Application::count();
        $awaiting       = Application::where('status', 'submitted')->count();
        $underReview    = Application::where('status', 'under_review')->count();
        $approved       = Application::where('status', 'approved')->count();
        $rejected       = Application::where('status', 'rejected')->count();

        // Average processing time
        $avgProcessing = Application::whereIn('status', ['approved','rejected'])
            ->select(DB::raw("AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours"))
            ->value('avg_hours');

        // Officer performance leaderboard
        $leaderboard = Application::whereIn('status', ['approved','rejected'])
            ->select('reviewer_id', DB::raw('COUNT(*) as handled'), DB::raw("AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours"))
            ->groupBy('reviewer_id')
            ->orderBy('handled', 'DESC')
            ->take(5)
            ->with('reviewer')
            ->get();

        // Gender distribution
        $genderCounts = Application::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total','gender');

        // County distribution
        $countyCounts = Application::select('current_county_id', DB::raw('count(*) as total'))
            ->groupBy('current_county_id')
            ->with('currentCounty')
            ->get();

        // Financier breakdown
        $financiers = Application::select('financier', DB::raw('count(*) as total'))
            ->groupBy('financier')
            ->pluck('total','financier');

        // KCSE grade distribution
        $grades = Application::select('kcse_mean_grade', DB::raw('count(*) as total'))
            ->groupBy('kcse_mean_grade')
            ->pluck('total','kcse_mean_grade');

        // Daily trend (last 30 days)
        $daily = Application::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw("DATE(created_at) as day"), DB::raw("count(*) as total"))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

//        return view('admin.registrar.dashboard.index', compact(
//            'total', 'awaiting', 'underReview', 'approved', 'rejected',
//            'avgProcessing', 'leaderboard', 'genderCounts', 'countyCounts',
//            'financiers', 'grades', 'daily'
//        ));
// Officer performance: fastest avg processing time
        $bestReviewer = Application::whereIn('status', ['approved', 'rejected'])
            ->select('reviewer_id', DB::raw("AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as speed"))
            ->groupBy('reviewer_id')
            ->orderBy('speed')
            ->first();

        $bestOfficer = $bestReviewer ? User::find($bestReviewer->reviewer_id) : null;
        $leaderboard = Application::whereIn('status', ['approved','rejected'])
            ->select('reviewer_id', DB::raw('COUNT(*) as handled'), DB::raw("AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours"))
            ->groupBy('reviewer_id')
            ->orderBy('handled', 'DESC')
            ->take(5)
            ->with('reviewer')
            ->get();

        return view('admin.registrar.dashboard.index', compact(
            'total',
            'awaiting',
            'underReview',
            'approved',
            'rejected',
            'avgProcessing',
            'bestOfficer',
            'bestReviewer',
            'genderCounts',
            'countyCounts',
            'financiers',
            'grades',
            'daily',
            'leaderboard'
        ));

    }

}
