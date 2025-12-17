@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#121212] overflow-hidden" 
     x-data="chatApp({{ json_encode($currentConversation ? json_decode($currentConversation->messages) : []) }}, '{{ $currentConversation ? $currentConversation->id : '' }}')">
    
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
                     
                    <div class="flex max-w-4xl w-full gap-4" :class="msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'">
                        <!-- Avatar -->
                        <div class="flex-shrink-0 h-9 w-9 rounded-full flex items-center justify-center mt-1" 
                             :class="msg.role === 'user' ? 'bg-[#2A2A2A]' : 'bg-transparent border border-[#333]'">
                             <template x-if="msg.role === 'user'">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                             </template>
                             <template x-if="msg.role !== 'user'">
                                <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                             </template>
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col min-w-0 flex-1" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                            <div class="flex items-center mb-1.5 opacity-90">
                                <span class="text-xs font-semibold text-white mr-2" x-text="msg.role === 'user' ? 'You' : 'AI'"></span>
                            </div>

                            <div class="relative text-[15px] tracking-wide w-full" 
                                 :class="msg.role === 'user' 
                                    ? 'bg-[#2A2A2A] text-[#E0E0E0] rounded-2xl rounded-tr-sm px-5 py-3 whitespace-pre-wrap max-w-max' 
                                    : 'text-[#D1D5DB] pt-1'">
                                
                                <!-- Thinking Block -->
                                <template x-if="parsed.thinking">
                                    <div class="mb-6 rounded-xl border border-[#333] bg-[#151515] overflow-hidden shadow-sm max-w-full">
                                        <button @click="isThinkingOpen = !isThinkingOpen" class="w-full flex items-center justify-between px-4 py-3 bg-[#1A1A1A] hover:bg-[#222] transition-colors group/think">
                                            <div class="flex items-center gap-2 text-xs font-medium text-[#A0A0A0] group-hover/think:text-white transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                <span>Thinking Process</span>
                                            </div>
                                            <svg class="w-3 h-3 text-[#666] transition-transform duration-200" :class="isThinkingOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <div x-show="isThinkingOpen" class="p-4 text-sm text-[#888] font-mono leading-relaxed whitespace-pre-wrap border-t border-[#333] bg-[#111] break-words" x-text="parsed.thinking"></div>
                                    </div>
                                </template>

                                <!-- Main Markdown Content -->
                                <div class="markdown-body min-w-0 break-words" x-html="marked.parse(parsed.main || (parsed.thinking ? '...' : ''))"></div>
                            </div>

                            <!-- Actions (AI Only) -->
                            <template x-if="msg.role !== 'user' && parsed.main">
                                <div class="flex items-center space-x-3 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pl-1">
                                    <button @click="copyToClipboard(parsed.main)" class="text-[#555] hover:text-[#E0E0E0] transition-colors" title="Copy">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                    <div class="h-3 w-[1px] bg-[#333]"></div>
                                    <button class="text-[#555] hover:text-[#E0E0E0] transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
            
            <x-thinking-indicator />
            <div id="messages-end"></div>
        </div>

        <!-- Input Area using Component -->
        <x-input-area :agents="$agents" :selectedAgent="$initialAgent" :isGuest="!Auth::check()" />
    </div>
    
    <x-login-modal />
</div>

@include('chat.scripts')
@endsection