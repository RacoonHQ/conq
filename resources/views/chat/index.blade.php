@extends('layouts.app')

@section('content')
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate-fade-in-up {
            animation-name: fadeInUp;
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }
    </style>

    <div class="flex h-screen bg-[#050505] overflow-hidden relative"
        x-data="chatApp({{ json_encode($currentConversation ? $currentConversation->messages : []) }}, '{{ $currentConversation ? $currentConversation->id : '' }}', {{ json_encode($agents) }}, '{{ $initialAgent }}')">

        <!-- Dynamic Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob">
            </div>
            <div
                class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob animation-delay-4000">
            </div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <!-- Sidebar -->
        <x-sidebar :conversations="$conversations" :user="Auth::user()" />

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col h-full relative w-full z-10">
            <!-- Mobile Header -->
            <div
                class="md:hidden flex items-center justify-between p-4 border-b border-white/5 bg-black/20 backdrop-blur-md">
                <button @click="sidebarOpen = true" class="text-[#E0E0E0] hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-bold text-white tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></span>
                <div class="w-6"></div>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6 scroll-smooth custom-scrollbar" id="messages-container">
                <!-- Empty State -->
                <template x-if="messages.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-center px-4 animate-fade-in-up">
                        <div
                            class="w-20 h-20 glass-card rounded-3xl flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(0,212,255,0.1)] group hover:scale-110 transition-transform duration-500">
                            <svg class="w-10 h-10 text-[#00D4FF] group-hover:rotate-12 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-2 tracking-tight">How can I help you today?</h3>
                        <p class="text-gray-500 max-w-sm">Start a conversation with one of our AI agents to explore
                            possibilities.</p>
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
                            <div class="flex flex-row-reverse gap-4 max-w-4xl w-full ml-auto animate-fade-in-up">
                                <!-- Avatar -->
                                <div class="flex-shrink-0 mt-0">
                                    <div
                                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center border border-white/10">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <!-- Content -->
                                <div class="flex flex-col items-end max-w-[85%]">
                                    <span
                                        class="text-xs text-[#888] mb-1 font-medium mr-1 uppercase tracking-wider">You</span>
                                    <div class="bg-blue-500/10 text-white rounded-2xl rounded-tr-sm px-5 py-3 border border-white/10 backdrop-blur-md shadow-lg text-[15px] leading-relaxed whitespace-pre-wrap text-left"
                                        x-text="msg.content"></div>
                                </div>
                            </div>
                        </template>

                        <!-- AI Layout -->
                        <template x-if="msg.role !== 'user'">
                            <div class="flex flex-row gap-4 max-w-4xl w-full mr-auto">
                                <!-- Avatar -->
                                <div class="flex-shrink-0 mt-1">
                                    <div
                                        class="w-8 h-8 rounded-full border border-[#333] bg-transparent flex items-center justify-center">
                                        <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <!-- Agent Header -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-bold text-white text-sm"
                                            x-text="getAgentName(msg.agentId || '{{ $initialAgent }}')"></span>
                                        <span
                                            class="text-[10px] px-1.5 py-0.5 rounded border border-[#333] text-[#666] bg-[#1A1A1A]"
                                            x-text="getAgentModel(msg.agentId || '{{ $initialAgent }}')"></span>
                                    </div>

                                    <!-- Thinking Block -->
                                    <template x-if="parsed.thinking">
                                        <div
                                            class="mb-4 rounded-xl border border-white/5 bg-white/5 overflow-hidden shadow-sm max-w-3xl backdrop-blur-sm">
                                            <button @click="isThinkingOpen = !isThinkingOpen"
                                                class="w-full flex items-center gap-2 px-3 py-2.5 bg-white/5 hover:bg-white/10 transition-colors group/think">
                                                <div class="w-2 h-2 rounded-full bg-[#00D4FF] animate-pulse"></div>
                                                <span
                                                    class="text-xs font-bold text-gray-300 group-hover:text-white uppercase tracking-widest">Thinking
                                                    Process</span>
                                                <span class="ml-auto text-[10px] text-gray-500 font-medium"
                                                    x-text="isThinkingOpen ? 'COLLAPSE' : 'EXPAND'"></span>
                                            </button>
                                            <div x-show="isThinkingOpen"
                                                class="p-4 text-xs text-gray-400 font-mono leading-relaxed border-t border-white/5 bg-black/40 break-words">
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
                                        <div
                                            class="flex items-center gap-3 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <button @click="copyToClipboard(parsed.main)"
                                                class="text-[#555] hover:text-[#E0E0E0] transition-colors" title="Copy">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                            <button class="text-[#555] hover:text-[#E0E0E0] transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
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
        <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50"
            x-data="{ show: false }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="glass-card rounded-2xl p-8 max-w-md mx-4 shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Delete Conversation</h3>
                </div>

                <p class="text-gray-400 mb-8 leading-relaxed text-[15px]">Are you sure you want to delete "<span
                        id="deleteConversationTitle" class="text-white font-semibold"></span>"? This action is irreversible.
                </p>

                <div class="flex justify-end gap-3">
                    <button onclick="closeDeleteModal()"
                        class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl transition-all font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()"
                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all font-bold shadow-[0_0_20px_rgba(239,68,68,0.3)] transform hover:scale-105 active:scale-95">
                        Delete Now
                    </button>
                </div>
            </div>
        </div>

        <!-- Custom Insufficient Credits Modal -->
        <div id="creditsModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50"
            x-data="{ show: false }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="glass-card rounded-2xl p-8 max-w-md mx-4 shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Insufficient Credits</h3>
                </div>

                <p class="text-gray-400 mb-8 leading-relaxed text-[15px]">You've reached your credit limit. Upgrade your plan to continue using advanced AI models.</p>

                <div class="flex justify-end gap-3">
                    <button onclick="closeCreditsModal()"
                        class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl transition-all font-medium">
                        Later
                    </button>
                    <button onclick="confirmCreditsRedirect()"
                        class="px-6 py-3 bg-gradient-to-r from-[#00D4FF] to-blue-500 text-black font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(0,212,255,0.3)] transform hover:scale-105 active:scale-95">
                        Upgrade Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('chat.scripts')
@endsection