@props(['conversations', 'user'])

<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0F0F0F] border-r border-[#222] transform transition-transform duration-300 md:relative md:translate-x-0 flex flex-col font-['Inter']"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       x-cloak>
    
    <!-- Header -->
    <div class="px-4 py-5 flex items-center justify-between">
        <h1 class="text-lg font-bold tracking-tight text-white cursor-pointer" @click="window.location.href='/'">
            CONQ<span class="text-[#00D4FF]">.</span>
        </h1>
        <div class="flex items-center">
             <a href="{{ $user ? route('dashboard') : route('login') }}" class="text-[#444] hover:text-white transition-colors p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
             </a>
        </div>
    </div>

    <!-- New Chat -->
    <div class="px-3 pb-6">
        <a href="{{ route('chat.index') }}" class="w-full flex items-center px-4 py-2.5 rounded-lg border border-[#333] hover:border-[#444] hover:bg-[#1A1A1A] transition-all group group bg-transparent text-white text-sm font-medium">
            <svg class="w-4 h-4 mr-2 text-[#888] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Chat
        </a>
    </div>

    <!-- History List -->
    <div class="flex-1 overflow-y-auto px-3 custom-scrollbar flex flex-col">
        <div class="text-[10px] font-bold text-[#444] uppercase tracking-widest mb-3 pl-2">Recent History</div>
        
        @auth
            @forelse($conversations as $convo)
                <a href="{{ route('chat.show', $convo) }}" class="block px-3 py-2 rounded-lg text-sm transition-all truncate mb-1 {{ request()->route('conversation')?->id === $convo->id ? 'bg-[#1A1A1A] text-white' : 'text-[#888] hover:bg-[#151515] hover:text-[#D1D5DB]' }}">
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        {{ $convo->title }}
                    </div>
                </a>
            @empty
                <div class="text-[11px] text-[#444] italic pl-2">No recent history.</div>
            @endforelse
        @else
             <div class="text-[11px] text-[#444] italic pl-2">No recent history.</div>
        @endauth
    </div>

    <!-- User Profile / Auth Actions -->
    <div class="p-3 border-t border-[#222]">
        @auth
            <a href="{{ route('profile') }}" class="flex items-center w-full px-2 py-2 hover:bg-[#1A1A1A] rounded-lg transition-colors group">
                <div class="w-8 h-8 rounded-full bg-[#00D4FF] flex items-center justify-center text-black font-bold mr-3 text-xs shadow-[0_0_10px_rgba(0,212,255,0.3)]">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <div class="text-sm font-semibold text-gray-200 truncate group-hover:text-white">{{ $user->name }}</div>
                    <div class="text-[10px] text-[#00D4FF] font-medium">{{ $user->plan ?? 'Free' }} Plan</div>
                </div>
            </a>
        @else
            <div class="bg-[#151515] rounded-xl p-4 border border-[#222]">
                <div class="flex items-center mb-2">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-xs font-medium text-gray-300">Guest User</span>
                </div>
                <p class="text-[10px] text-[#666] leading-relaxed mb-3">Sign up to save history and access advanced models.</p>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-[#00D4FF] hover:bg-[#00C0E5] rounded-lg text-xs font-bold text-black transition-all shadow-[0_0_15px_rgba(0,212,255,0.2)]">
                    Sign Up
                </a>
            </div>
        @endauth
    </div>
</aside>