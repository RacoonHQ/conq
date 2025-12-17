<div class="flex items-start gap-4 mb-6 animate-pulse" x-show="isThinking">
    <div class="flex-shrink-0 h-9 w-9 rounded-full flex items-center justify-center mt-1 bg-transparent border border-[#333]">
        <svg class="w-4 h-4 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>
    <div class="flex flex-col items-start mt-2">
        <div class="flex items-center gap-3">
            <span class="text-xs text-[#00D4FF] font-medium">Thinking</span>
            <div class="flex space-x-1">
                <div class="w-1.5 h-1.5 bg-[#00D4FF] rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-1.5 h-1.5 bg-[#00D4FF] rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-1.5 h-1.5 bg-[#00D4FF] rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>