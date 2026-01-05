@props(['conversations', 'user'])

<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-black/20 backdrop-blur-xl border-r border-white/5 transform transition-transform duration-300 md:relative md:translate-x-0 flex flex-col font-['Inter']"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-data="sidebarComponent({{ json_encode(collect($conversations)->map(function ($c) {
    return ['id' => $c->id, 'title' => $c->title]; })->toArray()) }}, '{{ request()->route('conversation')?->id }}')"
    x-cloak>

    <!-- Mobile Close Button - Center Right -->
    <button @click="sidebarOpen = false" 
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="md:hidden absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 bg-black/80 backdrop-blur-md border border-white/10 rounded-full p-2 text-[#444] hover:text-white transition-all duration-200 hover:scale-110 hover:bg-black/90 shadow-lg z-10"
        title="Close sidebar">
        <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Header -->
    <div class="px-4 py-5 flex items-center justify-between">
        <h1 class="text-lg font-bold tracking-tight text-white cursor-pointer" @click="window.location.href='/'">
            CONQ<span class="text-[#00D4FF]">.</span>
        </h1>
        <div class="flex items-center">
            <a href="{{ $user ? route('dashboard') : route('login') }}"
                class="text-[#444] hover:text-white transition-colors p-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </a>
        </div>
    </div>

    <!-- New Chat -->
    <div class="px-3 pb-6">
        <button @click="createNewChat()"
            class="w-full flex items-center px-4 py-2.5 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-[#00D4FF]/50 transition-all group text-white text-sm font-semibold shadow-lg backdrop-blur-md">
            <svg class="w-4 h-4 mr-2 text-[#00D4FF] group-hover:scale-110 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Chat
        </button>
    </div>

    <!-- History List -->
    <div class="flex-1 overflow-y-auto px-3 custom-scrollbar flex flex-col">
        <div class="text-[10px] font-bold text-[#444] uppercase tracking-widest mb-3 pl-2">Recent History</div>

        @auth
            <template x-for="convo in conversations" :key="convo.id">
                <div class="block px-3 py-2 rounded-lg text-sm transition-all truncate mb-1"
                    :class="currentConversationId == convo.id ? 'bg-[#1A1A1A] text-white' : 'text-[#888] hover:bg-[#151515] hover:text-[#D1D5DB]'"
                    x-data="{ isHovered: false }" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                    <div class="flex items-center justify-between">
                        <a @click="loadConversation(convo.id)" class="flex items-center flex-1 min-w-0 cursor-pointer">
                            <svg class="w-3.5 h-3.5 mr-3 opacity-70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <span class="truncate" x-text="convo.title"></span>
                        </a>
                        <button @click="deleteConversation(convo.id, convo.title)"
                            :class="isHovered ? 'opacity-100' : 'opacity-0'"
                            class="ml-2 p-1 rounded transition-opacity duration-200 text-[#555] hover:text-red-400 hover:bg-[#2A1A1A] flex-shrink-0"
                            title="Delete conversation">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
            <div x-show="conversations.length === 0" class="text-[11px] text-[#444] italic pl-2">No recent history.</div>
        @else
            <div class="text-[11px] text-[#444] italic pl-2">No recent history.</div>
        @endauth
    </div>

    <!-- User Profile / Auth Actions -->
    <div class="p-3 border-t border-[#222]">
        @auth
            <a href="{{ route('profile') }}"
                class="flex items-center w-full px-2 py-2 hover:bg-[#1A1A1A] rounded-lg transition-colors group">
                <div
                    class="w-8 h-8 rounded-full bg-[#00D4FF] flex items-center justify-center text-black font-bold mr-3 text-xs shadow-[0_0_10px_rgba(0,212,255,0.3)]">
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
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs font-medium text-gray-300">Guest User</span>
                </div>
                <p class="text-[10px] text-[#666] leading-relaxed mb-3">Sign up to save history and access advanced models.
                </p>
                <a href="{{ route('register') }}"
                    class="block w-full text-center px-4 py-2 bg-[#00D4FF] hover:bg-[#00C0E5] rounded-lg text-xs font-bold text-black transition-all shadow-[0_0_15px_rgba(0,212,255,0.2)]">
                    Sign Up
                </a>
            </div>
        @endauth
    </div>
</aside>

<script>
    function sidebarComponent(initialConversations, currentConversationId) {
        return {
            conversations: initialConversations,
            currentConversationId: currentConversationId,

            init() {
                // Listen for conversation updates from chat
                window.addEventListener('conversation-updated', (e) => {
                    this.updateConversations();
                });

                // Listen for conversation deletion
                window.addEventListener('conversation-deleted', (e) => {
                    this.removeConversation(e.detail.conversationId);
                });

                // Listen for new conversation created
                window.addEventListener('conversation-created', (e) => {
                    this.addConversation(e.detail.conversation);
                });

                // Listen for conversation title updates
                window.addEventListener('conversation-title-updated', (e) => {
                    this.updateConversationTitle(e.detail.conversationId, e.detail.title);
                });
            },

            async updateConversations() {
                try {
                    const response = await fetch('/api/conversations', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.conversations = data;
                    }
                } catch (error) {
                    console.error('Failed to update conversations:', error);
                }
            },

            addConversation(conversation) {
                // Add to beginning of array
                this.conversations.unshift(conversation);
            },

            removeConversation(conversationId) {
                this.conversations = this.conversations.filter(c => c.id !== conversationId);
            },

            updateConversationTitle(conversationId, newTitle) {
                const conversation = this.conversations.find(c => c.id == conversationId);
                if (conversation) {
                    conversation.title = newTitle;
                }
            },

            deleteConversation(conversationId, conversationTitle) {
                // Use existing global delete function
                if (typeof deleteConversation === 'function') {
                    deleteConversation(conversationId, conversationTitle);
                }
            },

            async loadConversation(conversationId) {
                try {
                    // Emit event to chat app to load conversation
                    window.dispatchEvent(new CustomEvent('load-conversation', {
                        detail: { conversationId: conversationId }
                    }));

                    // Update current conversation ID
                    this.currentConversationId = conversationId;

                    // Update URL without page refresh
                    history.pushState({ conversationId: conversationId }, '', `/prompt/${conversationId}`);

                } catch (error) {
                    console.error('Failed to load conversation:', error);
                    window.location.href = `/prompt/${conversationId}`; // Fallback to page refresh
                }
            },

            createNewChat() {
                // Emit event to chat app to create new chat
                window.dispatchEvent(new CustomEvent('create-new-chat'));

                // Update current conversation ID to null
                this.currentConversationId = null;

                // Update URL without page refresh
                history.pushState({ conversationId: null }, '', '/prompt');
            }
        }
    }
</script>