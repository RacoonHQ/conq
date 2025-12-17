@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A0A] text-white font-['Inter']">
     <header class="relative z-10 px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></a>
        <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-white flex items-center gap-2">Back</a>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <div class="text-center mb-20">
            <h1 class="text-4xl md:text-6xl font-bold mb-8 leading-tight">Empowering Intelligence <br /> for Everyone.</h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto font-light">CONQ is a next-generation multi-model AI platform.</p>
        </div>
    </main>
</div>
@endsection