<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $history = $user->conversations;
        
        // Count total prompts/messages from all conversations
        $totalPrompts = 0;
        foreach ($history as $conversation) {
            $messages = $conversation->messages ?? [];
            // Count user messages (prompts) - assuming user messages have 'role' => 'user'
            foreach ($messages as $message) {
                if (isset($message['role']) && $message['role'] === 'user') {
                    $totalPrompts++;
                }
            }
        }
        
        $totalQueries = $totalPrompts;
        $timeSaved = round($totalPrompts * 0.5); // 0.5 hours saved per prompt
        $remainingCredits = $user->remaining_credits;

        return view('dashboard', compact('user', 'history', 'totalQueries', 'timeSaved', 'remainingCredits'));
    }

    public function destroyAll()
    {
        $user = Auth::user();
        $user->conversations()->delete();
        
        return redirect()->route('dashboard')->with('success', 'All conversations have been deleted.');
    }
}