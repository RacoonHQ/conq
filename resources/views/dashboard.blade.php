@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] text-[#E0E0E0]">
    <header class="border-b border-[#333] bg-[#1A1A1A]">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('chat.index') }}" class="mr-4 p-2 rounded hover:bg-[#333] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
                <h1 class="text-xl font-bold font-['JetBrains_Mono']">Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-[#A0A0A0]">{{ $user->name }}</div>
                <div class="w-8 h-8 rounded-full bg-[#00D4FF] flex items-center justify-center text-black font-bold text-xs">{{ substr($user->name, 0, 2) }}</div>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Stats -->
            <div class="bg-[#1A1A1A] p-6 rounded-2xl border border-[#333]">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-[#A0A0A0] text-xs uppercase tracking-wider mb-1">Total Queries</div>
                        <div class="text-3xl font-bold text-white">{{ $totalQueries }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-[#1A1A1A] p-6 rounded-2xl border border-[#333]">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-[#A0A0A0] text-xs uppercase tracking-wider mb-1">Time Saved</div>
                        <div class="text-3xl font-bold text-white">{{ $timeSaved }}h</div>
                    </div>
                </div>
            </div>
            <div class="bg-[#1A1A1A] p-6 rounded-2xl border border-[#333]">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-[#A0A0A0] text-xs uppercase tracking-wider mb-1">Credits</div>
                        <div class="text-3xl font-bold text-white">{{ $user->credits }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-[#1A1A1A] rounded-2xl border border-[#333] p-6">
                <h3 class="text-lg font-semibold mb-6 flex items-center">Recent Conversations</h3>
                <div class="space-y-4">
                    @forelse($history->take(5) as $item)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-[#252525] transition-colors cursor-pointer border border-transparent hover:border-[#333]">
                            <div>
                                <div class="text-sm font-medium text-white mb-1">{{ $item->title }}</div>
                                <div class="text-xs text-[#666]">{{ $item->agent_id }}</div>
                            </div>
                            <div class="text-xs text-[#555]">{{ $item->created_at->format('M d') }}</div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 text-sm">No conversations yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                 <div class="bg-gradient-to-br from-[#1A1A1A] to-[#111] rounded-2xl border border-[#333] p-6 relative overflow-hidden">
                    <h3 class="text-lg font-semibold mb-2">Upgrade to Pro</h3>
                    <p class="text-sm text-[#A0A0A0] mb-6">Unlock higher rate limits.</p>
                    <a href="{{ route('pricing') }}" class="py-2.5 px-6 rounded bg-[#00D4FF] text-black font-semibold text-sm hover:bg-[#64FDDA] transition-colors">View Plans</a>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection