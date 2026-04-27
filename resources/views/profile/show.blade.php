<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/30 ring-1 ring-indigo-400/30">
                    <span class="material-icons text-white text-xl" aria-hidden="true">person</span>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-white leading-tight tracking-tight uppercase">
                        User <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Profile</span>
                    </h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">Profile information · contact details · project data</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen font-display">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors">
                    <span class="material-icons text-sm">arrow_back</span>
                    Back to Dashboard
                </a>
            </div>

            <x-profile-card 
                :user="$profileUser" 
                :show-contact="$showContact" 
                :is-own-profile="$isOwnProfile" 
            />

            @if(!$isOwnProfile && Auth::user()->role === 'supervisor' && $profileUser->role === 'student')
            <!-- Supervisor Actions -->
            <div class="mt-8 bg-slate-900 rounded-[40px] border border-indigo-500/30 overflow-hidden shadow-2xl shadow-black/40 ring-1 ring-indigo-500/20">
                <div class="px-6 sm:px-8 py-6 border-b border-slate-800 bg-gradient-to-r from-slate-900 via-indigo-950/20 to-slate-900">
                    <h3 class="text-xl font-bold text-white">Supervisor Actions</h3>
                    <p class="text-slate-400 text-sm mt-1">Manage this student's academic progress</p>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('dashboard') }}#student-{{ $profileUser->id }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-indigo-600/25 ring-1 ring-indigo-400/30 transition hover:from-indigo-500 hover:to-indigo-600 active:scale-[0.98]">
                            <span class="material-icons text-sm" aria-hidden="true">visibility</span>
                            View Chapters
                        </a>
                        <a href="mailto:{{ $profileUser->email }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-amber-600/25 ring-1 ring-amber-400/30 transition hover:from-amber-500 hover:to-amber-600 active:scale-[0.98]">
                            <span class="material-icons text-sm" aria-hidden="true">email</span>
                            Send Email
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
