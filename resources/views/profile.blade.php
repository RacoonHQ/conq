@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] text-[#E0E0E0] flex flex-col items-center pt-20 px-4">
    <div class="w-full max-w-2xl">
        <a href="{{ route('chat.index') }}" class="text-[#A0A0A0] hover:text-white flex items-center transition-colors mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Back to Chat
        </a>

        <div class="bg-[#1A1A1A] rounded-2xl border border-[#333] overflow-hidden shadow-2xl" x-data="{ editing: false }">
            <div class="h-32 bg-gradient-to-r from-[#00D4FF]/20 to-[#64FDDA]/20 border-b border-[#333]"></div>
            
            <div class="px-8 pb-8">
                <div class="relative -mt-12 mb-6 flex justify-between items-end">
                    <div class="w-24 h-24 rounded-full bg-[#121212] border-4 border-[#1A1A1A] flex items-center justify-center relative overflow-hidden">
                        <span class="text-black font-bold text-2xl z-10 bg-gradient-to-br from-[#00D4FF] to-[#64FDDA] w-full h-full flex items-center justify-center">{{ substr($user->name, 0, 2) }}</span>
                    </div>
                    <button @click="editing = !editing" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center bg-[#333] text-white hover:bg-[#444]">
                        <span x-text="editing ? 'Cancel' : 'Edit Profile'"></span>
                    </button>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Display Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" :disabled="!editing" class="w-full bg-[#121212] border rounded-lg py-2.5 px-4 text-white focus:outline-none transition-colors text-sm" :class="editing ? 'border-[#555] focus:border-[#00D4FF]' : 'border-transparent'">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Email Address</label>
                        <input type="email" name="email" value="{{ $user->email }}" :disabled="!editing" class="w-full bg-[#121212] border rounded-lg py-2.5 px-4 text-white focus:outline-none transition-colors text-sm" :class="editing ? 'border-[#555] focus:border-[#00D4FF]' : 'border-transparent'">
                    </div>

                    <div x-show="editing" class="flex justify-end">
                        <button type="submit" class="bg-[#00D4FF] text-black px-4 py-2 rounded font-semibold">Save Changes</button>
                    </div>
                </form>
                
                <div class="pt-6 border-t border-[#333] mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-xs text-gray-300 border border-[#444] px-3 py-1 rounded hover:bg-[#333] transition-colors">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection