@props(['user', 'showContact' => false, 'isOwnProfile' => false])

<div class="bg-slate-900 rounded-[40px] border border-indigo-500/30 overflow-hidden shadow-2xl shadow-black/40 ring-1 ring-indigo-500/20">
    <div class="px-6 sm:px-8 py-6 border-b border-slate-800 bg-gradient-to-r from-slate-900 via-indigo-950/20 to-slate-900">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 flex items-center justify-center text-white font-black text-lg uppercase shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                    <p class="text-slate-400 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            @if($isOwnProfile)
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-indigo-600/25 ring-1 ring-indigo-400/30 transition hover:from-indigo-500 hover:to-indigo-600 active:scale-[0.98]">
                    <span class="material-icons text-sm" aria-hidden="true">edit</span>
                    Edit Profile
                </a>
            @endif
        </div>
    </div>
    
    <div class="p-6 sm:p-8 space-y-6">
        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Role</span>
                <span class="inline-flex items-center rounded-full border border-{{ $user->getStatusColor() }}-500/40 bg-{{ $user->getStatusColor() }}-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-{{ $user->getStatusColor() }}-300 ring-1 ring-{{ $user->getStatusColor() }}-500/20">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            <div>
                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">University ID</span>
                <span class="text-sm font-mono text-slate-300">{{ $user->university_id ?? '—' }}</span>
            </div>
            <div>
                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Department</span>
                <span class="text-sm text-slate-300">{{ $user->department ?? '—' }}</span>
            </div>
            <div>
                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Status</span>
                <span class="inline-flex items-center rounded-full border border-{{ $user->getStatusColor() }}-500/40 bg-{{ $user->getStatusColor() }}-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-{{ $user->getStatusColor() }}-300 ring-1 ring-{{ $user->getStatusColor() }}-500/20">
                    {{ $user->getDisplayStatus() }}
                </span>
            </div>
        </div>

        @if($showContact)
        <!-- Contact Information -->
        <div class="border-t border-slate-800 pt-6">
            <h4 class="text-lg font-bold text-white mb-4">Contact Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($user->phone)
                <div>
                    <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block mb-2">Phone</span>
                    <span class="text-sm text-slate-300">{{ $user->phone }}</span>
                </div>
                @endif
                @if($user->address)
                <div class="md:col-span-2">
                    <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block mb-2">Address</span>
                    <span class="text-sm text-slate-300">{{ $user->address }}</span>
                </div>
                @endif
                @if($user->emergency_contact)
                <div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-2">Emergency Contact</span>
                    <span class="text-sm text-slate-300">{{ $user->emergency_contact }}</span>
                </div>
                @endif
                @if($user->emergency_phone)
                <div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-2">Emergency Phone</span>
                    <span class="text-sm text-slate-300">{{ $user->emergency_phone }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($user->hasProposal())
        <!-- Project Information -->
        <div class="border-t border-slate-800 pt-6">
            <h4 class="text-lg font-bold text-white mb-4">Project Information</h4>
            <div class="space-y-3">
                <div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Project Title</span>
                    <span class="text-sm text-slate-300">{{ $user->project_title }}</span>
                </div>
                @if($user->project_description)
                <div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Project Description</span>
                    <span class="text-sm text-slate-300">{{ $user->project_description }}</span>
                </div>
                @endif
                @if($user->supervisor)
                <div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Supervisor</span>
                    <span class="text-sm text-slate-300">{{ $user->supervisor->name }} ({{ $user->supervisor->email }})</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
