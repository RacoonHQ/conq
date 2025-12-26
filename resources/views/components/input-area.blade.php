@props(['agents', 'selectedAgent', 'isGuest'])

<div class="w-full px-4 pb-6 pt-2 z-20 bg-transparent" x-data="inputArea()">

    <div class="max-w-3xl mx-auto relative">
        <div class="relative flex flex-col rounded-[26px] border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl transition-all"
            :class="isDragging ? 'border-[#00D4FF] bg-[#00D4FF]/10' : ''" @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)">

            <!-- Drag Overlay -->
            <div x-show="isDragging"
                class="absolute inset-0 rounded-[26px] flex items-center justify-center bg-[#00D4FF]/10 z-30 pointer-events-none backdrop-blur-sm">
                <div class="flex flex-col items-center text-[#00D4FF]">
                    <svg class="w-8 h-8 mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="font-semibold">{{ $isGuest ? "Login to Upload" : "Drop file here" }}</span>
                </div>
            </div>

            <!-- Attachment Preview -->
            <template x-if="attachment">
                <div class="px-4 pt-4 flex items-center">
                    <div
                        class="flex items-center bg-[#252525] text-sm text-gray-200 px-3 py-1.5 rounded-lg border border-[#333]">
                        <svg class="w-3.5 h-3.5 mr-2 text-[#00D4FF]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="truncate max-w-[200px]" x-text="attachment.name"></span>
                        <button @click="attachment = null" class="ml-2 text-gray-500 hover:text-red-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Textarea -->
            <textarea x-model="input" @keydown.enter.prevent="submit()"
                class="w-full bg-transparent text-[#E0E0E0] placeholder-[#555] px-5 py-4 focus:outline-none resize-none min-h-[56px] max-h-[200px] leading-relaxed rounded-[26px] text-[15px]"
                rows="1" placeholder="Tanya apa saja. Ketik @ untuk menyebut."></textarea>

            <!-- Toolbar -->
            <div class="flex items-center justify-between px-3 pb-2.5 pt-1">

                <!-- Left: Agent Selector -->
                <!-- Left: Agent Selector -->
                <div class="flex items-center gap-1 pl-1">
                    <div class="relative" x-data="{ menuOpen: false }" @click.outside="menuOpen = false">
                        <button @click="menuOpen = !menuOpen"
                            class="w-9 h-9 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 transition-colors border border-white/10 hover:border-[#00D4FF]/50"
                            :class="agentId ? 'text-[#00D4FF]' : 'text-[#888]'">
                            <!-- Thinking AI Icon -->
                            <svg x-show="agentId === 'thinking_ai'" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <!-- Code AI Icon -->
                            <svg x-show="agentId === 'code_ai'" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <!-- Reasoning AI Icon -->
                            <svg x-show="agentId === 'reasoning_ai'" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            <!-- Math AI Icon -->
                            <svg x-show="agentId === 'math_ai'" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </button>

                        <div x-show="menuOpen" x-cloak
                            class="absolute bottom-full left-0 mb-3 w-56 bg-[#1E1E1E] border border-[#333] rounded-xl shadow-xl overflow-hidden z-50 p-1">
                            @foreach($agents as $key => $agent)
                                <button @click="agentId = '{{ $key }}'; menuOpen = false"
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm flex items-center gap-3 transition-colors hover:bg-[#2A2A2A] group relative"
                                    :class="agentId === '{{ $key }}' ? 'bg-[#2A2A2A]' : ''">
                                    <div class="flex-shrink-0"
                                        :class="agentId === '{{ $key }}' ? 'text-[#00D4FF]' : 'text-[#666] group-hover:text-[#999]'">
                                        @if($key === 'thinking_ai')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                        @elseif($key === 'code_ai')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                            </svg>
                                        @elseif($key === 'reasoning_ai')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        @elseif($key === 'math_ai')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-xs group-hover:text-white"
                                            :class="agentId === '{{ $key }}' ? 'text-white' : 'text-[#888]'">{{ $agent['name'] }}</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-6 w-[1px] bg-[#333] mx-2"></div>

                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-[#666] hover:text-white transition-colors"
                        title="Web Search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </button>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2">
                    <input type="file" x-ref="fileInput" class="hidden" @change="handleFileChange($event)">

                    <button @click="triggerFile()"
                        class="text-[#888] transition-all p-2 rounded-xl hover:text-white hover:bg-white/10"
                        :class="isGuest ? 'cursor-not-allowed opacity-50' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </button>

                    <button @click="toggleMic()" class="transition-all p-2 rounded-xl hover:bg-white/10"
                        :class="isListening ? 'text-red-500 animate-pulse' : 'text-[#888] hover:text-white'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>

                    <button @click="submit()" :disabled="isLoading ? false : (!input.trim() && !attachment)"
                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 ml-1 border"
                        :class="isLoading 
                                ? 'bg-white/5 border-red-500/50 text-red-500 hover:bg-red-500/10' 
                                : ((input.trim() || attachment) 
                                    ? 'bg-gradient-to-br from-[#00D4FF] to-blue-500 border-transparent text-black shadow-[0_0_20px_rgba(0,212,255,0.3)] hover:scale-105 active:scale-95' 
                                    : 'bg-white/5 border-white/5 text-[#444] cursor-not-allowed')">
                        <template x-if="isLoading">
                            <!-- Stop Icon -->
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <rect x="6" y="6" width="12" height="12" rx="2" />
                            </svg>
                        </template>
                        <template x-if="!isLoading">
                            <!-- Send Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </template>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-[10px] text-[#444] font-medium">CONQ can make mistakes. Verify important information.</p>
        </div>
    </div>
</div>

<script>
    function inputArea() {
        return {
            isDragging: false,
            attachment: null,
            isListening: false,
            recognition: null,
            isGuest: @json($isGuest),
            input: '',
            isLoading: false,

            init() {
                // Listen for AI thinking state
                window.addEventListener('ai-thinking-start', () => { this.isLoading = true; });
                window.addEventListener('ai-thinking-end', () => { this.isLoading = false; });

                // Initialize Speech Recognition
                if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                    this.recognition = new SpeechRecognition();
                    this.recognition.continuous = false;
                    this.recognition.lang = 'en-US';
                    this.recognition.interimResults = false;

                    this.recognition.onresult = (event) => {
                        const transcript = event.results[0][0].transcript;
                        this.input += (this.input ? ' ' : '') + transcript;
                        this.isListening = false;
                    };

                    this.recognition.onerror = () => {
                        this.isListening = false;
                        window.toast('Voice input error', 'error');
                    };

                    this.recognition.onend = () => {
                        this.isListening = false;
                    };
                }
            },

            handleDrop(e) {
                this.isDragging = false;
                if (this.isGuest) {
                    window.showLoginModal();
                    return;
                }
                const files = e.dataTransfer.files;
                if (files.length > 0) this.attachment = files[0];
            },

            triggerFile() {
                if (this.isGuest) {
                    window.showLoginModal();
                    return;
                }
                this.$refs.fileInput.click();
            },

            handleFileChange(e) {
                if (this.isGuest) {
                    window.showLoginModal();
                    return;
                }
                if (e.target.files.length > 0) this.attachment = e.target.files[0];
            },

            toggleMic() {
                if (!this.recognition) {
                    window.toast('Browser does not support voice input', 'error');
                    return;
                }
                if (this.isListening) {
                    this.recognition.stop();
                    this.isListening = false;
                } else {
                    this.recognition.start();
                    this.isListening = true;
                    window.toast('Listening...', 'info');
                }
            },

            submit() {
                if (this.isLoading) {
                    window.dispatchEvent(new CustomEvent('chat-stop'));
                    return;
                }

                if (!this.input.trim() && !this.attachment) return;

                let message = this.input;
                if (this.attachment) {
                    message = `[Attached File: ${this.attachment.name}]\n\n` + message;
                    this.attachment = null;
                }

                window.dispatchEvent(new CustomEvent('chat-submit', {
                    detail: { message: message }
                }));
                this.input = '';
            }
        }
    }
</script>