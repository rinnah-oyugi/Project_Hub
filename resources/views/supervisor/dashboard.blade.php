<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight tracking-tight ">
                    {{ __('SUPERVISOR HUB') }}
                </h2>
                <p class="text-slate-500 text-xs mt-1 font-medium uppercase tracking-widest">Research & Project Management</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col text-right mr-4 border-r border-slate-800 pr-4">
                    <span class="text-emerald-600 font-black tracking-widest uppercase text-sm">{{ Auth::user()->name }}</span>
                    <span class="text-indigo-600 text-xs font-medium uppercase tracking-tighter">Project Supervisor</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 bg-slate-900 text-red-500 rounded-xl border border-slate-800 hover:bg-red-500/10 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="C17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Active Students</p>
                    <h3 class="text-5xl font-black text-white mt-2">{{ $students->where('request_status', 'approved')->count() }}</h3>
                </div>
                <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Pending Proposals</p>
                    <h3 class="text-5xl font-black text-amber-500 mt-2">{{ $students->where('request_status', 'pending')->count() }}</h3>
                </div>
                <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Approved Chapters</p>
                    <h3 class="text-5xl font-black text-emerald-500 mt-2">0</h3>
                </div>
            </div>

            {{-- INCOMING REQUESTS TABLE (Same as before) --}}
            <div class="bg-slate-900 shadow-2xl rounded-3xl border border-slate-800 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">Incoming Student Requests</h3>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-800/50">
                        @forelse($students->where('request_status', 'pending') as $student)
                        <tr class="hover:bg-slate-800/30">
                            <td class="px-8 py-6 text-white font-bold">{{ $student->name }}</td>
                            <td class="px-8 py-6 text-slate-300 text-sm">{{ $student->project_title }}</td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('status.update', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase">Approve</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td class="px-8 py-10 text-center text-slate-500 italic">No pending requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ACTIVE PROJECTS & FEEDBACK SECTION --}}
            <div class="bg-slate-900 shadow-2xl rounded-3xl border border-slate-800 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">Active Project Progress & Feedback</h3>
                </div>
                <div class="p-8 space-y-6">
                    @forelse($students->where('request_status', 'approved') as $student)
                        <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800" x-data="{ open: false }">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-white font-black text-xl">{{ $student->name }}</h4>
                                    <p class="text-indigo-400 text-sm font-medium">{{ $student->project_title }}</p>
                                </div>
                                <button @click="open = !open" class="text-xs font-black uppercase tracking-widest bg-slate-800 text-slate-300 px-6 py-3 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    Provide Feedback
                                </button>
                            </div>

                            {{-- FEEDBACK FORM (Hidden by default) --}}
                            <div x-show="open" x-transition class="mt-8 pt-8 border-t border-slate-800">
                                <form action="{{ route('chapter.feedback', $student->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Supervisor Comment</label>
                                            <textarea name="comment" rows="3" class="w-full mt-2 bg-slate-900 border-slate-700 rounded-xl text-white text-sm focus:ring-indigo-500" placeholder="Type your review here..."></textarea>
                                        </div>
                                        <div class="flex flex-col justify-end gap-3">
                                            <select name="status" class="bg-slate-900 border-slate-700 rounded-xl text-white text-sm py-3">
                                                <option value="pending">Mark as Pending</option>
                                                <option value="needs revision">Needs Revision</option>
                                                <option value="approved">Approved</option>
                                            </select>
                                            <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase py-4 rounded-xl text-xs tracking-widest shadow-lg shadow-indigo-500/20">
                                                Send Review to Student
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 italic">No approved students yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>