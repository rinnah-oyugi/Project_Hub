<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/30 ring-1 ring-indigo-400/30">
                    <span class="material-icons text-white text-xl" aria-hidden="true">shield</span>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-white leading-tight tracking-tight uppercase">
                        Admin <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Control</span>
                    </h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">Governance · approvals · access</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen font-display">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group bg-slate-900 p-8 rounded-[40px] border border-indigo-500/30 hover:border-indigo-500/50 transition-all relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-indigo-500/15 rounded-2xl flex items-center justify-center mb-6 ring-1 ring-indigo-500/30">
                            <span class="material-icons text-indigo-400" aria-hidden="true">group</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Directory</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">All registered accounts (including approved).</p>
                        <span class="text-3xl font-black text-white tabular-nums">{{ $totalUsers }}</span>
                        <span class="block text-[10px] font-black text-indigo-400 uppercase tracking-widest mt-2">Total users</span>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-600/10 rounded-full blur-3xl"></div>
                </div>

                <div class="group bg-slate-900 p-8 rounded-[40px] border border-indigo-500/30 hover:border-indigo-500/50 transition-all relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-amber-500/15 rounded-2xl flex items-center justify-center mb-6 ring-1 ring-amber-500/35">
                            <span class="material-icons text-amber-400" aria-hidden="true">hourglass_empty</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Review queue</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Supervisor accounts waiting for admin approval.</p>
                        <span class="text-3xl font-black text-amber-400 tabular-nums">{{ $pendingCount }}</span>
                        <span class="block text-[10px] font-black text-amber-500/80 uppercase tracking-widest mt-2">Pending approvals</span>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/10 rounded-full blur-3xl"></div>
                </div>

                <div class="group bg-slate-900 p-8 rounded-[40px] border border-indigo-500/30 hover:border-indigo-500/50 transition-all relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-2 ring-1 ring-slate-700">
                            <span class="material-icons text-indigo-400 text-xl" aria-hidden="true">school</span>
                        </div>
                        <h3 class="text-xl font-bold text-white">Access model</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Students register as <span class="text-emerald-400 font-semibold">active</span> immediately. Only <span class="text-indigo-300 font-semibold">supervisors</span> require your approval before they can use the hub.</p>
                    </div>
                </div>
            </div>

            <section class="space-y-4" aria-labelledby="approvals-heading">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 px-1">
                    <div>
                        <h2 id="approvals-heading" class="text-2xl font-black text-white tracking-tight uppercase flex items-center gap-3">
                            Account approvals
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-500/15 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-indigo-300 ring-1 ring-indigo-500/40">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                </span>
                                All accounts
                            </span>
                        </h2>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[40px] border border-indigo-500/30 overflow-hidden shadow-2xl shadow-black/40 ring-1 ring-indigo-500/20">
                    <div class="px-6 sm:px-10 py-5 border-b border-slate-800 bg-gradient-to-r from-slate-900 via-indigo-950/20 to-slate-900 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm text-slate-400 font-medium">Approve <span class="text-indigo-300 font-semibold">supervisor</span> accounts. Students are already active and appear here for directory visibility only.</p>
                        @if($pendingCount > 0)
                            <span class="shrink-0 rounded-full bg-indigo-600/20 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-indigo-300 ring-1 ring-indigo-500/40">{{ $pendingCount }} in queue</span>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[640px] text-left">
                            <thead class="bg-slate-950/80 text-slate-500 uppercase text-[10px] font-black tracking-[0.2em] border-b border-slate-800">
                                <tr>
                                    <th class="px-6 sm:px-10 py-5">Identity</th>
                                    <th class="px-6 sm:px-10 py-5">University ID</th>
                                    <th class="px-6 sm:px-10 py-5">Role</th>
                                    <th class="px-6 sm:px-10 py-5">Department</th>
                                    <th class="px-6 sm:px-10 py-5">Status</th>
                                    <th class="px-6 sm:px-10 py-5 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80">
                                @forelse($directoryUsers as $user)
                                    <tr class="hover:bg-slate-800/25 transition-colors">
                                        <td class="px-6 sm:px-10 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 flex items-center justify-center text-white font-black text-xs uppercase shrink-0">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <span class="text-white font-bold block">{{ $user->name }}</span>
                                                    <span class="text-slate-500 text-[10px] font-black uppercase tracking-tighter">{{ $user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 sm:px-10 py-6">
                                            <span class="text-sm font-mono text-slate-300">{{ $user->university_id ?? '—' }}</span>
                                        </td>
                                        <td class="px-6 sm:px-10 py-6">
                                            @if($user->role === 'supervisor')
                                                <span class="inline-flex items-center rounded-full border border-indigo-500/40 bg-indigo-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-indigo-300 ring-1 ring-indigo-500/20">
                                                    Supervisor
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-amber-500/40 bg-amber-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-300 ring-1 ring-amber-500/20">
                                                    Student
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 sm:px-10 py-6 text-slate-400 font-medium text-sm">
                                            {{ $user->department ?? '—' }}
                                        </td>
                                        <td class="px-6 sm:px-10 py-6">
                                            @if($user->role === 'student')
                                                <span class="inline-flex items-center rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-300 ring-1 ring-emerald-500/25">Active</span>
                                            @elseif($user->is_approved)
                                                <span class="inline-flex items-center rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-300 ring-1 ring-emerald-500/25">Active</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-amber-500/40 bg-amber-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-300 ring-1 ring-amber-500/25">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 sm:px-10 py-6 text-right">
                                            @if($user->role === 'supervisor' && ! $user->is_approved)
                                                <form action="{{ route('admin.approve.user', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-indigo-600/25 ring-1 ring-indigo-400/30 transition hover:from-indigo-500 hover:to-indigo-600 active:scale-[0.98]">
                                                        <span class="material-icons text-sm" aria-hidden="true">verified_user</span>
                                                        Approve
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-slate-600 text-xs font-medium uppercase tracking-widest">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-10 py-20 text-center">
                                            <div class="flex flex-col items-center max-w-md mx-auto">
                                                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-indigo-500/10 ring-1 ring-indigo-500/30">
                                                    <span class="material-icons text-indigo-400 text-4xl" aria-hidden="true">verified</span>
                                                </div>
                                                <p class="text-white font-black uppercase tracking-widest text-xs mb-2">No accounts yet</p>
                                                <p class="text-slate-500 text-sm leading-relaxed">Students and supervisors will appear in this directory after they register.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="rounded-[40px] border border-indigo-500/30 bg-gradient-to-br from-indigo-950/40 to-slate-900 p-8 sm:p-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Gate status</span>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xl font-bold text-white">Active</span>
                    </div>
                </div>
                <div>
                    <span class="text-[10px] font-black text-amber-500/90 uppercase tracking-widest block mb-2">Pending now</span>
                    <span class="text-xl font-bold text-amber-400 tabular-nums">{{ $pendingCount }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Directory size</span>
                    <span class="text-xl font-bold text-white tabular-nums">{{ $totalUsers }}</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
