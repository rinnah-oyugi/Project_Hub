<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white leading-tight tracking-tight">
            {{ __('STUDENT PORTAL') }}
        </h2>
        <p class="text-slate-500 text-xs mt-1 font-medium uppercase tracking-widest">Project Progress Tracker</p>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-slate-800">Project Status</h2>

                {{-- STATUS: PENDING --}}
                @if(Auth::user()->request_status == 'pending')
                    <div class="bg-amber-50 border border-amber-200 p-6 rounded-3xl shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-amber-500 text-white rounded-2xl animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-amber-800 font-black uppercase text-[10px] tracking-widest">Proposal Under Review</h3>
                                <p class="text-amber-900 font-bold text-lg">{{ Auth::user()->project_title }}</p>
                                <p class="text-amber-700 text-sm italic">Waiting for supervisor approval...</p>
                            </div>
                        </div>
                    </div>

                {{-- STATUS: APPROVED (SHOWS UPLOAD FORM) --}}
                @elseif(Auth::user()->request_status == 'approved')
                    <div class="bg-emerald-50/50 p-8 rounded-[40px] border-2 border-emerald-100 shadow-sm">
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <div class="bg-emerald-500 p-4 rounded-2xl shadow-lg shadow-emerald-500/20 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <div class="flex-1 w-full">
                                <div class="mb-6">
                                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Proposal Approved: {{ Auth::user()->project_title }}</h3>
                                    <p class="text-slate-500 font-medium">Your research journey has officially begun. Submit your first chapter below.</p>
                                </div>

                                <form action="{{ route('chapter.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm space-y-4">
                                    @csrf
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Select Chapter File (PDF/DOCX)</label>
                                            <input type="file" name="chapter_file" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer" />
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Chapter Title</label>
                                            <input type="text" name="chapter_name" placeholder="e.g. Chapter 1: Introduction" class="w-full px-4 py-2 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20" required>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Message to Supervisor</label>
                                        <textarea name="student_comment" rows="3" placeholder="Explain what you've covered or ask a specific question..." class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20"></textarea>
                                    </div>

                                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                        Submit for Review 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                {{-- STATUS: DECLINED --}}
                @elseif(Auth::user()->request_status == 'declined')
                    <div class="bg-red-50 border border-red-200 p-6 rounded-3xl shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-red-500 text-white rounded-2xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-red-800 font-black uppercase text-[10px] tracking-widest">Proposal Declined</h3>
                                    <p class="text-red-900 font-bold text-lg">Changes Required</p>
                                    <p class="text-red-700 text-sm italic">Please contact your supervisor for feedback.</p>
                                </div>
                            </div>
                            <a href="{{ route('proposal.create') }}" class="bg-red-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-red-700 transition">
                                Resubmit
                            </a>
                        </div>
                    </div>

                {{-- STATUS: NONE (INITIAL STATE) --}}
                @else
                    <div class="bg-white border border-slate-200 p-12 rounded-[40px] text-center shadow-xl shadow-slate-200/50">
                        <div class="p-5 bg-indigo-50 text-indigo-600 rounded-3xl w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-slate-900 font-black text-2xl mb-2 tracking-tight">Ready to start your research?</h3>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">Connect with a supervisor and submit your proposal topic to begin your academic journey.</p>
                        <a href="{{ route('proposal.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition-all hover:scale-105 shadow-xl shadow-indigo-500/20">
                            Create New Proposal
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>