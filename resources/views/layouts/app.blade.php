<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CONQ - AI Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- KaTeX CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
    <!-- Highlight.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/contrib/auto-render.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121212; color: #E0E0E0; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #121212; }
        ::-webkit-scrollbar-thumb { background: #444; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        [x-cloak] { display: none !important; }
        
        /* Markdown Styles */
        .markdown-body pre { background: #1E1E1E; padding: 1rem; border-radius: 0.5rem; border: 1px solid #333; overflow-x: auto; margin-bottom: 1rem; }
        .markdown-body code { font-family: 'JetBrains Mono', monospace; font-size: 0.9em; }
        .markdown-body :not(pre) > code { background: #2A2A2A; color: #00D4FF; padding: 0.1rem 0.3rem; border-radius: 0.25rem; border: 1px solid #333; }
        .markdown-body p { margin-bottom: 1rem; line-height: 1.6; }
        .markdown-body ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .markdown-body ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .markdown-body strong { color: #fff; font-weight: 600; }
        .markdown-body blockquote { border-left: 4px solid #333; padding-left: 1rem; color: #888; margin-bottom: 1rem; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col" x-data="{ toasts: [] }" @notify.window="toasts.push({message: $event.detail.message, type: $event.detail.type || 'info', id: Date.now()}); setTimeout(() => { toasts.shift() }, 3000)">
    
    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-[100] flex flex-col gap-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div class="pointer-events-auto flex items-center p-4 rounded-lg shadow-2xl border min-w-[300px] transition-all transform bg-[#151515]"
                 :class="{
                    'border-green-500/50': toast.type === 'success',
                    'border-red-500/50': toast.type === 'error',
                    'border-[#00D4FF]/50': toast.type === 'info'
                 }"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 translate-y-2">
                <div class="mr-3">
                   <template x-if="toast.type === 'success'"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></template>
                   <template x-if="toast.type === 'error'"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></template>
                   <template x-if="toast.type === 'info'"><svg class="w-5 h-5 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></template>
                </div>
                <p class="text-sm text-white font-medium flex-1" x-text="toast.message"></p>
            </div>
        </template>
    </div>

    @yield('content')

    <script>
        // Global utility to dispatch toasts from anywhere
        window.toast = (message, type = 'info') => {
            window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
        };
    </script>
</body>
</html>