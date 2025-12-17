<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $history = $user->conversations;
        $totalQueries = $history->count(); // Simplified metric
        $timeSaved = round($totalQueries * 0.5);

        return view('dashboard', compact('user', 'history', 'totalQueries', 'timeSaved'));
    }
}