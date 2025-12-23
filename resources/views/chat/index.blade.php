@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#121212] overflow-hidden" 
     x-data="chatApp({{ json_encode($currentConversation ? $currentConversation->messages : []) }}, '{{ $currentConversation ? $currentConversation->id : '' }}')">
    
    <!-- Sidebar -->
    <x-sidebar :conversations="$conversations" :user="Auth::user()" />

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col h-full relative w-full">
        <!-- Mobile Header -->
        <div class="md:hidden flex items-center justify-between p-4 border-b border-[#333] bg-[#121212]">
            <button @click="sidebarOpen = true" class="text-[#E0E0E0]"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
            <span class="font-semibold text-white">CONQ.</span>
            <div class="w-6"></div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-6 scroll-smooth custom-scrollbar" id="messages-container">
            <!-- Empty State -->
            <template x-if="messages.length === 0">
                <div class="h-full flex flex-col items-center justify-center text-center opacity-50 px-4">
                    <div class="w-16 h-16 bg-[#1A1A1A] rounded-2xl flex items-center justify-center mb-4 border border-[#333]">
                        <svg class="w-8 h-8 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#E0E0E0] mb-2">How can I help you today?</h3>
                </div>
            </template>

            <!-- Message Loop using Component -->
            <template x-for="msg in messages" :key="msg.id">
                <!-- We pass the JS object to the Blade component wrapper logic handled by Alpine inside the component -->
                <!-- Note: Since Alpine loops happen client-side, we can't use server-side Blade component syntax inside x-for directly for dynamic data binding easily without x-html or similar. 
                     However, to keep it clean and performant, we will replicate the MessageBubble structure purely in Alpine inside this loop, 
                     referencing the structure we defined in the component file for consistency. -->
                
                <div class="flex w-full mb-8 group" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                     x-data="{ 
                        isThinkingOpen: false, 
                        parsed: { main: '', thinking: '' },
                        init() {
                            this.parseContent();
                            this.$watch('msg.content', () => this.parseContent());
                        },
                        parseContent() {
                            const raw = msg.content || '';
                            const thinkMatch = raw.match(/<think>([\s\S]*?)(?:<\/think>|$)/);
                            this.parsed.thinking = thinkMatch ? thinkMatch[1].trim() : null;
                            this.parsed.main = raw.replace(/<think>[\s\S]*?(?:<\/think>|$)/, '').trim();
                            
                            this.$nextTick(() => {
                                if(window.renderMathInElement) window.renderMathInElement(this.$el);
                                this.$el.querySelectorAll('pre code').forEach(block => hljs.highlightElement(block));
                            });
                        },
                        copyToClipboard(text) {
                            navigator.clipboard.writeText(text);
                            window.toast('Copied to clipboard!', 'success');
                        }
                     }">

                    <!-- User Layout -->
                    <template x-if="msg.role === 'user'">
                        <div class="flex flex-row-reverse gap-4 max-w-4xl w-full ml-auto">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 mt-0">
                                <div class="w-9 h-9 rounded-full bg-[#2A2A2A] flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="flex flex-col items-end max-w-[85%]">
                                <span class="text-xs text-[#888] mb-1 font-medium mr-1">You</span>
                                <div class="bg-[#2A2A2A] text-[#E0E0E0] rounded-2xl rounded-tr-sm px-5 py-3 shadow-md text-[15px] leading-relaxed whitespace-pre-wrap text-left" x-text="msg.content"></div>
                            </div>
                        </div>
                    </template>

                    <!-- AI Layout -->
                    <template x-if="msg.role !== 'user'">
                        <div class="flex flex-row gap-4 max-w-4xl w-full mr-auto">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full border border-[#333] bg-transparent flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Agent Header -->
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-white text-sm" x-text="msg.role === 'model' ? 'Thinking AI' : 'AI'"></span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded border border-[#333] text-[#666] bg-[#1A1A1A]">openai/gpt oss</span>
                                </div>

                                <!-- Thinking Block -->
                                <template x-if="parsed.thinking">
                                    <div class="mb-4 rounded-lg border border-[#333] bg-[#151515] overflow-hidden shadow-sm max-w-3xl">
                                        <button @click="isThinkingOpen = !isThinkingOpen" class="w-full flex items-center gap-2 px-3 py-2 bg-[#1A1A1A] hover:bg-[#222] transition-colors group/think">
                                            <svg class="w-3.5 h-3.5 text-[#888] group-hover/think:text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                            <span class="text-xs font-semibold text-[#888] group-hover/think:text-[#00D4FF]">Thinking Process</span>
                                            <span class="ml-auto text-[10px] text-[#555]" x-text="isThinkingOpen ? 'Hide' : 'View'"></span>
                                        </button>
                                        <div x-show="isThinkingOpen" 
                                             class="p-3 text-xs text-[#999] font-mono leading-relaxed border-t border-[#333] bg-[#0F0F0F] break-words">
                                             <div x-text="parsed.thinking"></div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Main Content -->
                                <div class="markdown-body prose prose-invert prose-p:leading-relaxed prose-pre:bg-[#151515] prose-pre:border prose-pre:border-[#333] min-w-0 max-w-none text-[#D1D5DB]" 
                                     x-html="marked.parse(parsed.main || (parsed.thinking ? '' : ''))">
                                </div>

                                <!-- Actions -->
                                <template x-if="parsed.main">
                                    <div class="flex items-center gap-3 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button @click="copyToClipboard(parsed.main)" class="text-[#555] hover:text-[#E0E0E0] transition-colors" title="Copy">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button class="text-[#555] hover:text-[#E0E0E0] transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            
            <x-thinking-indicator />
            <div id="messages-end"></div>
        </div>

        <!-- Input Area using Component -->
        <x-input-area :agents="$agents" :selectedAgent="$initialAgent" :isGuest="!Auth::check()" />
    </div>
    
    <x-login-modal />
    
    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" x-data="{ show: false }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-[#1A1A1A] border border-[#333] rounded-xl p-6 max-w-md mx-4 shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-500 bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Delete Conversation</h3>
            </div>
            
            <p class="text-[#888] mb-6">Are you sure you want to delete "<span id="deleteConversationTitle" class="text-white font-medium"></span>"? This action cannot be undone.</p>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-[#2A2A2A] hover:bg-[#333] text-[#888] hover:text-white rounded-lg transition-colors">
                    Cancel
                </button>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

@include('chat.scripts')
@endsection