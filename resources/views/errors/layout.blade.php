<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - CONQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #050505; color: #fff; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen overflow-hidden relative">
    <!-- Ambient Background -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
         <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-screen filter blur-[128px] opacity-10"></div>
         <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#64FDDA] rounded-full mix-blend-screen filter blur-[128px] opacity-10"></div>
    </div>

    <div class="relative z-10 text-center max-w-lg mx-auto px-4">
        <div class="relative mb-4">
            <h1 class="text-[8rem] md:text-[12rem] font-bold text-[#1A1A1A] leading-none select-none">
                @yield('code')
            </h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-16 h-16 text-[#00D4FF] opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white tracking-tight">
            @yield('message')
        </h2>
        
        <p class="text-[#A0A0A0] text-lg mb-8">
            @yield('description')
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="flex items-center justify-center px-6 py-3 rounded-lg bg-[#00D4FF] text-black font-semibold hover:bg-[#64FDDA] transition-colors">
                Back Home
            </a>
        </div>
    </div>
</body>
</html>