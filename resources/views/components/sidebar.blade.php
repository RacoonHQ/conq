@props(['conversations', 'user'])

<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0F0F0F] border-r border-[#444] transform transition-transform duration-300 md:relative md:translate-x-0 flex flex-col"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       x-cloak>
    
    <!-- Header -->
    <div class="px-4 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold tracking-tight text-white font-['JetBrains_Mono'] cursor-pointer" @click="window.location.href='/'">
            CONQ<span class="text-[#00D4FF]">.</span>
        </h1>
        <a href="{{ route('dashboard') }}" class="text-[#666] hover:text-white" title="Dashboard">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        </a>
    </div>

    <!-- New Chat -->
    <div class="px-4 pb-4">
        <a href="{{ route('chat.index') }}" class="w-full flex items-center justify-start px-4 py-3 rounded-lg font-medium text-sm border border-dashed border-[#444] hover:border-[#00D4FF] hover:bg-[#00D4FF]/5 text-[#A0A0A0] hover:text-[#00D4FF] transition-all group">
            <svg class="w-4 h-4 mr-3 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Chat
        </a>
    </div>

    <!-- History List -->
    <div class="flex-1 overflow-y-auto px-3 custom-scrollbar">
        <div class="text-[10px] font-bold text-[#555] uppercase tracking-wider mb-2 pl-2">Recent History</div>
        @forelse($conversations as $convo)
            <a href="{{ route('chat.show', $convo) }}" class="block px-3 py-2 rounded text-sm transition-colors truncate {{ request()->route('conversation')?->id === $convo->id ? 'bg-[#1A1A1A] text-white' : 'text-[#A0A0A0] hover:bg-[#1A1A1A] hover:text-white' }}">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    {{ $convo->title }}
                </div>
            </a>
        @empty
            <div class="text-xs text-[#444] italic pl-2">No recent history.</div>
        @endforelse
    </div>

    <!-- User Profile -->
    <div class="border-t border-[#444] p-3 bg-[#121212]">
        <a href="{{ route('profile') }}" class="flex items-center w-full px-2 py-2 hover:bg-[#1A1A1A] rounded transition-colors">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#00D4FF] to-[#64FDDA] flex items-center justify-center text-black font-bold mr-3 text-xs">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div class="overflow-hidden">
                <div class="text-sm font-medium text-white truncate">{{ $user->name }}</div>
                <div class="text-[10px] text-[#00D4FF]">{{ $user->plan }} Plan</div>
            </div>
        </a>
    </div>
</aside>