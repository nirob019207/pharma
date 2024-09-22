<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard() {
        // Get today's date
        $today = Carbon::today();
    
        // Count new users by today's date
        $totalUsers = DB::table('users')
            ->count();
    
        // Count new medicines added today
        $totalMedicinesToday = DB::table('medicines')
            ->whereDate('created_at', $today)
            ->count();
    
        // Count stock transactions today
        $totalStockToday = DB::table('stocks')
            ->whereDate('created_at', $today)
            ->count();
    
        // Count sales transactions today
        $totalSalesToday = DB::table('sales')
            ->whereDate('created_at', $today)
            ->count();
    
        // Pass the counts to the view
        return view('admin.dashboard', compact('totalUsers', 'totalMedicinesToday', 'totalStockToday', 'totalSalesToday'));
    }
    
}
