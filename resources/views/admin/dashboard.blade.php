<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <span class="material-icons text-white">shield</span>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-white leading-tight tracking-tight uppercase">
                        Admin <span class="text-indigo-500">Control</span>
                    </h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">System Governance & User Security</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen font-display">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group bg-slate-900 p-8 rounded-[40px] border border-slate-800 hover:border-indigo-500/50 transition-all relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6">
                            <span class="material-icons text-indigo-500">group</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">User Management</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Configure system-wide permissions and department structures.</p>
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">1,240 Total Registered</span>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>
                </div>

                <div class="group bg-slate-900 p-8 rounded-[40px] border border-slate-800 hover:border-amber-500/50 transition-all relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6">
                            <span class="material-icons text-amber-500">psychology</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Allocation Engine</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Automated pairing algorithms for student-supervisor matching.</p>
                        <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest italic">Optimization Phase: ON</span>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl"></div>
                </div>

                <div class="group bg-slate-900 p-8 rounded-[40px] border border-slate-800 hover:border-slate-600 transition-all relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-6">
                            <span class="material-icons text-slate-400">settings</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">System Config</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Set submission deadlines and institutional grading schemes.</p>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Semester 1 Setup</span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between px-4">
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">User Approvals <span class="text-amber-500 text-sm ml-2">●</span></h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Pending Verification</p>
                </div>

                <div class="bg-slate-900 rounded-[40px] border border-slate-800 overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-950/50 text-slate-500 uppercase text-[10px] font-black tracking-[0.2em] border-b border-slate-800">
                            <tr>
                                <th class="px-10 py-6">Identity</th>
                                <th class="px-10 py-6">Role</th>
                                <th class="px-10 py-6">Department</th>
                                <th class="px-10 py-6 text-right">Gatekeeper Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse(\App\Models\User::where('is_approved', false)->where('role', '!=', 'admin')->get() as $user)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white font-bold text-xs uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="text-white font-bold block">{{ $user->name }}</span>
                                            <span class="text-slate-500 text-[10px] font-black uppercase tracking-tighter">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border 
                                        {{ $user->role === 'supervisor' ? 'border-indigo-500/30 text-indigo-500 bg-indigo-500/5' : 'border-amber-500/30 text-amber-500 bg-amber-500/5' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-slate-400 font-medium text-sm">
                                    {{ $user->department ?? 'General' }}
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <form action="{{ route('admin.approve.user', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-white text-slate-900 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all transform hover:-translate-y-1 shadow-lg active:scale-95">
                                            Approve Access
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-10 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="material-icons text-slate-700 text-5xl mb-4">verified</span>
                                        <p class="text-slate-500 font-medium uppercase tracking-widest text-xs">All accounts are currently verified</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-indigo-600/5 rounded-[40px] p-10 border border-indigo-500/10 grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-2">Uptime</span>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xl font-bold text-white">99.9%</span>
                    </div>
                </div>
                <div>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-2">Live Projects</span>
                    <span class="text-xl font-bold text-white">842 Total</span>
                </div>
                <div>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-2">Last Audit</span>
                    <span class="text-xl font-bold text-white">2 Mins Ago</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">System Version</span>
                    <span class="text-xl font-bold text-slate-400">2.1.0-Release</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>