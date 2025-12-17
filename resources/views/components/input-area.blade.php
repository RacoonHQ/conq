@props(['agents', 'selectedAgent', 'isGuest'])

<div class="w-full px-4 pb-6 pt-2 z-20 bg-[#121212]"
     x-data="inputArea()">
    
    <div class="max-w-3xl mx-auto relative">
        <div class="relative flex flex-col rounded-[2rem] border border-[#444] bg-[#151515] shadow-2xl transition-all"
             :class="isDragging ? 'border-[#00D4FF] bg-[#00D4FF]/5' : ''"
             @dragover.prevent="isDragging = true"
             @dragleave.prevent="isDragging = false"
             @drop.prevent="handleDrop($event)">
            
            <!-- Drag Overlay -->
            <div x-show="isDragging" class="absolute inset-0 rounded-[2rem] flex items-center justify-center bg-[#00D4FF]/10 z-30 pointer-events-none backdrop-blur-sm">
                <div class="flex flex-col items-center text-[#00D4FF]">
                    <svg class="w-8 h-8 mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span class="font-semibold">{{ $isGuest ? "Login to Upload" : "Drop file here" }}</span>
                </div>
            </div>

            <!-- Attachment Preview -->
            <template x-if="attachment">
                <div class="px-4 pt-4 flex items-center">
                    <div class="flex items-center bg-[#252525] text-sm text-gray-200 px-3 py-1.5 rounded-lg border border-[#333]">
                        <svg class="w-3.5 h-3.5 mr-2 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <span class="truncate max-w-[200px]" x-text="attachment.name"></span>
                        <button @click="attachment = null" class="ml-2 text-gray-500 hover:text-red-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Textarea -->
            <textarea 
                x-model="input" 
                @keydown.enter.prevent="submit()"
                class="w-full bg-transparent text-[#E0E0E0] placeholder-[#666] px-5 py-4 focus:outline-none resize-none min-h-[56px] max-h-[200px] leading-relaxed rounded-[2rem]"
                rows="1"
                placeholder="Ask anything..."
            ></textarea>

            <!-- Toolbar -->
            <div class="flex items-center justify-between px-3 pb-3 pt-1">
                
                <!-- Left: Agent Selector -->
                <div class="flex items-center gap-2">
                    <div class="relative" x-data="{ menuOpen: false }" @click.outside="menuOpen = false">
                        <button @click="menuOpen = !menuOpen" class="w-9 h-9 flex items-center justify-center rounded-full bg-[#252525] text-[#00D4FF] hover:bg-[#333] transition-colors border border-transparent hover:border-[#444]">
                            <!-- Current Agent Icon (Simplified) -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </button>

                        <div x-show="menuOpen" x-cloak class="absolute bottom-full left-0 mb-3 w-56 bg-[#1E1E1E] border border-[#333] rounded-xl shadow-xl overflow-hidden z-50">
                            @foreach($agents as $key => $agent)
                                <button @click="agentId = '{{ $key }}'; menuOpen = false" 
                                        class="w-full text-left px-3 py-2.5 rounded-lg text-sm flex items-center gap-3 transition-colors hover:bg-[#2A2A2A] group">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-xs group-hover:text-white" :class="agentId === '{{ $key }}' ? 'text-[#00D4FF]' : 'text-gray-400'">{{ $agent['name'] }}</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="h-6 w-[1px] bg-[#333] mx-1"></div>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-white hover:bg-[#252525] transition-colors" title="Web Search (Coming Soon)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </button>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-3">
                    <input type="file" x-ref="fileInput" class="hidden" @change="handleFileChange($event)">
                    
                    <button @click="triggerFile()" class="text-[#666] hover:text-[#E0E0E0] transition-colors p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </button>

                    <button @click="toggleMic()" class="transition-colors p-2" :class="isListening ? 'text-red-500 animate-pulse' : 'text-[#666] hover:text-[#E0E0E0]'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                    </button>

                    <button @click="submit()" :disabled="isLoading || (!input.trim() && !attachment)" 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg"
                            :class="isLoading ? 'bg-red-500/10 text-red-500 border border-red-500' : ((input.trim() || attachment) ? 'bg-[#00D4FF] text-black hover:bg-[#64FDDA] hover:scale-105' : 'bg-[#252525] text-[#555] cursor-not-allowed')">
                         <template x-if="isLoading">
                             <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-current"></div>
                         </template>
                         <template x-if="!isLoading">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                         </template>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-3">
             <p class="text-[10px] text-[#444]">CONQ can make mistakes. Verify important information.</p>
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

            init() {
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
                if(this.isGuest) {
                    this.showLoginModal = true; 
                    return;
                }
                const files = e.dataTransfer.files;
                if(files.length > 0) this.attachment = files[0];
            },

            triggerFile() {
                if(this.isGuest) {
                    this.showLoginModal = true; 
                    return;
                }
                this.$refs.fileInput.click();
            },

            handleFileChange(e) {
                if(e.target.files.length > 0) this.attachment = e.target.files[0];
            },

            toggleMic() {
                if(!this.recognition) {
                    window.toast('Browser does not support voice input', 'error');
                    return;
                }
                if(this.isListening) {
                    this.recognition.stop();
                    this.isListening = false;
                } else {
                    this.recognition.start();
                    this.isListening = true;
                    window.toast('Listening...', 'info');
                }
            },

            submit() {
                if(this.attachment) {
                    // For now, prepend attachment name to prompt as text since we don't have real file upload backend in this demo
                    this.input = `[Attached File: ${this.attachment.name}]\n\n` + this.input;
                    this.attachment = null;
                }
                this.sendMessage();
            }
        }
    }
</script>