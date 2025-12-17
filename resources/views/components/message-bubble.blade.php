@props(['message'])

<div class="flex w-full mb-8 group" :class="{{ $message['role'] === 'user' ? 'true' : 'false' }} ? 'justify-end' : 'justify-start'"
     x-data="{ 
        isThinkingOpen: false, 
        rawContent: `{{ addslashes($message['content']) }}`,
        parsed: { main: '', thinking: '' },
        init() {
            this.parseContent();
            this.$watch('rawContent', () => this.parseContent());
        },
        parseContent() {
            const thinkMatch = this.rawContent.match(/<think>([\s\S]*?)(?:<\/think>|$)/);
            this.parsed.thinking = thinkMatch ? thinkMatch[1].trim() : null;
            this.parsed.main = this.rawContent.replace(/<think>[\s\S]*?(?:<\/think>|$)/, '').trim();
            
            // Re-render math and code after content update
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
    
    <div class="flex max-w-4xl w-full gap-4" :class="{{ $message['role'] === 'user' ? 'true' : 'false' }} ? 'flex-row-reverse' : 'flex-row'">
        
        <!-- Avatar -->
        <div class="flex-shrink-0 h-9 w-9 rounded-full flex items-center justify-center mt-1" 
             class="{{ $message['role'] === 'user' ? 'bg-[#2A2A2A]' : 'bg-transparent border border-[#333]' }}">
            @if($message['role'] === 'user')
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            @else
                <!-- Dynamic Icon based on Agent ID (simplified logic) -->
                @if(str_contains($message['agent_id'] ?? '', 'code'))
                    <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                @elseif(str_contains($message['agent_id'] ?? '', 'math'))
                    <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                @else
                    <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                @endif
            @endif
        </div>

        <!-- Content -->
        <div class="flex flex-col min-w-0 flex-1" :class="{{ $message['role'] === 'user' ? 'true' : 'false' }} ? 'items-end' : 'items-start'">
            <div class="flex items-center mb-1.5 opacity-90">
                <span class="text-xs font-semibold text-white mr-2">
                    {{ $message['role'] === 'user' ? 'You' : 'AI' }}
                </span>
            </div>

            <div class="relative text-[15px] tracking-wide w-full" 
                 :class="{{ $message['role'] === 'user' ? 'true' : 'false' }} 
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
            @if($message['role'] !== 'user')
                <div class="flex items-center space-x-3 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pl-1">
                    <button @click="copyToClipboard(parsed.main)" class="text-[#555] hover:text-[#E0E0E0] transition-colors" title="Copy">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <div class="h-3 w-[1px] bg-[#333]"></div>
                    <button class="text-[#555] hover:text-[#E0E0E0] transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg></button>
                </div>
            @endif
        </div>
    </div>
</div>