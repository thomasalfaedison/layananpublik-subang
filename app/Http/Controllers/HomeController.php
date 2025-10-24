<?php

namespace App\Http\Controllers;

use App\Models\VisitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->toDateString();
        $sessionKey = 'visited_on_date';

        if ($request->session()->get($sessionKey) !== $today) {
            VisitLog::create([
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->header('User-Agent'), 0, 255),
            ]);

            $request->session()->put($sessionKey, $today);
        }

        $totalVisitors = VisitLog::count();
        $todayVisitors = VisitLog::whereDate('created_at', now()->toDateString())->count();
        $monthlyVisitors = VisitLog::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $yearlyVisitors = VisitLog::whereYear('created_at', now()->year)->count();

        return view('home.index', compact('totalVisitors', 'todayVisitors', 'monthlyVisitors', 'yearlyVisitors'));
    }
}
