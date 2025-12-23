@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#0A0A0A] text-white flex flex-col font-['Inter'] overflow-x-hidden relative selection:bg-[#00D4FF] selection:text-black"
        x-data="homeLogic()">

        <!-- Navbar -->
        <header class="relative max-w-7xl mx-auto px-4 md:px-6 py-4 flex items-center justify-between w-full z-20">
            <div class="flex items-center gap-2 cursor-pointer" @click="window.location.href='/'">
                <h1 class="text-xl font-bold tracking-tight text-white font-['Inter'] flex items-center gap-1">
                    <span class="font-extrabold text-2xl">CONQ</span><span class="text-[#00D4FF] text-2xl">.</span>
                </h1>
            </div>

            <nav
                class="hidden lg:flex items-center gap-6 text-sm text-gray-400 font-medium absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <a href="{{ route('docs') }}" class="hover:text-white transition-colors">Docs</a>
                <a href="{{ route('pricing') }}" class="hover:text-white transition-colors">Pricing</a>
                <a href="{{ route('help') }}" class="hover:text-white transition-colors">Help</a>
                <a href="{{ route('about') }}" class="hover:text-white transition-colors">About</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-sm font-medium hover:text-white text-gray-300 hidden sm:block">Dashboard</a>
                    <a href="{{ route('chat.index') }}"
                        class="bg-[#00D4FF] hover:bg-[#00C0E5] text-black text-sm font-semibold px-4 py-2 rounded-md transition-colors shadow-lg shadow-[#00D4FF]/20">Open
                        Chat</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium hover:text-white text-gray-300 hidden sm:block">Sign in</a>
                    <a href="{{ route('register') }}"
                        class="bg-[#00D4FF] hover:bg-[#00C0E5] text-black text-sm font-semibold px-4 py-2 rounded-md transition-colors shadow-lg shadow-[#00D4FF]/20">Get
                        started</a>
                @endauth
            </div>
        </header>

        <!-- Main -->
        <main
            class="flex-1 flex flex-col items-center justify-center -mt-20 px-4 relative z-10 w-full max-w-[1400px] mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-[5rem] font-bold text-center tracking-tight mb-6 leading-[1.1]">
                What will you <span class="text-[#00D4FF] italic font-serif">conquer</span> today?
            </h1>
            <p class="text-gray-400 text-lg md:text-xl text-center mb-12 max-w-2xl font-light">
                Experience the power of multi-model AI agents.
            </p>

            <!-- Input Box -->
            <div class="w-full max-w-2xl relative group">
                <div
                    class="relative bg-[#151515] border border-[#333] rounded-2xl p-4 shadow-2xl transition-all duration-300 group-hover:border-[#444]">
                    <textarea x-model="prompt" @keydown.enter.prevent="startChat()" :placeholder="placeholderText"
                        class="w-full bg-transparent text-lg text-gray-200 placeholder-gray-600 outline-none resize-none min-h-[80px] font-light"
                        autofocus></textarea>

                    <div class="flex items-center justify-between mt-4 pl-1">
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-[#222] text-gray-300 hover:bg-[#333] hover:text-white transition-colors text-sm font-medium">
                                <span x-text="agents[selectedAgent].name"></span>
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </button>

                            <div x-show="open" x-cloak
                                class="absolute bottom-full left-0 mb-2 w-64 bg-[#1E1E1E] border border-[#333] rounded-xl shadow-xl overflow-hidden z-50">
                                <template x-for="(agent, id) in agents" :key="id">
                                    <button @click="selectedAgent = id; open = false"
                                        class="w-full text-left px-3 py-2.5 text-sm hover:bg-[#2A2A2A] transition-colors flex flex-col">
                                        <span class="font-medium"
                                            :class="selectedAgent === id ? 'text-[#00D4FF]' : 'text-gray-200'"
                                            x-text="agent.name"></span>
                                        <span class="text-[10px] text-gray-500" x-text="agent.role"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <button @click="startChat()"
                            class="bg-[#3D758F] hover:bg-[#00D4FF] text-white hover:text-black text-sm font-medium px-5 py-2 rounded-full flex items-center gap-2 transition-all">
                            <span>Conquer</span>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Wave Animation Styles -->
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
        </style>

        <!-- Dynamic Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob">
            </div>
            <div
                class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-4000">
            </div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

    </div>

    <script>
        function homeLogic() {
            return {
                prompt: '',
                selectedAgent: 'thinking_ai',
                agents: {
                    thinking_ai: { name: 'Thinking AI', role: 'Ideation' },
                    code_ai: { name: 'Code AI', role: 'Programming' },
                    reasoning_ai: { name: 'Reasoning AI', role: 'Logic' },
                    math_ai: { name: 'Math AI', role: 'Math' }
                },
                placeholderText: '',
                isDeleting: false,
                txtIndex: 0,
                texts: ["anything...", "to write Python...", "to explain quantum physics...", "to solve calculus..."],

                init() {
                    this.type();
                },
                type() {
                    const current = this.texts[this.txtIndex % this.texts.length];
                    const base = `Ask ${this.agents[this.selectedAgent].name} `;

                    if (this.isDeleting) {
                        this.placeholderText = base + current.substring(0, this.placeholderText.length - base.length - 1);
                    } else {
                        this.placeholderText = base + current.substring(0, this.placeholderText.length - base.length + 1);
                    }

                    let typeSpeed = this.isDeleting ? 30 : 100;

                    if (!this.isDeleting && this.placeholderText === base + current) {
                        typeSpeed = 2000;
                        this.isDeleting = true;
                    } else if (this.isDeleting && this.placeholderText === base) {
                        this.isDeleting = false;
                        this.txtIndex++;
                        typeSpeed = 500;
                    }

                    setTimeout(() => this.type(), typeSpeed);
                },
                startChat() {
                    if (!this.prompt.trim()) return;
                    // Since this is server-rendered, we pass state via query or session. 
                    // For this migration, we'll assume the chat page reads from query params primarily.
                    window.location.href = `/prompt?mode=user&prompt=${encodeURIComponent(this.prompt)}&agent=${this.selectedAgent}`;
                }
            }
        }
    </script>
@endsection