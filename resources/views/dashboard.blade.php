<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30 ring-1 ring-amber-400/30">
                <span class="material-icons text-white text-xl" aria-hidden="true">school</span>
            </div>
            <div>
                <h2 class="font-black text-3xl text-white leading-tight tracking-tight">
                    {{ __('STUDENT PORTAL') }}
                </h2>
                <p class="text-amber-400 text-xs mt-1 font-medium uppercase tracking-widest">Project Progress Tracker</p>
            </div>
        </div>
    </x-slot>

    @php
        $u = Auth::user();
        $proposalApproved = $u->request_status === 'approved';
        $proposalPending = $u->request_status === 'pending' && $u->hasProposal();
        $proposalDeclined = $u->request_status === 'declined';
        $needsProposalForm = ! $proposalApproved && (! $u->hasProposal() || $proposalDeclined);
    @endphp

    <div class="py-12 bg-gradient-to-br from-amber-50/50 to-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <span class="material-icons text-white text-sm" aria-hidden="true">analytics</span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Project Status</h2>
                </div>

                {{-- Proposal approved: new upload + chapter timeline --}}
                @if ($proposalApproved)
                    <div class="rounded-[40px] border border-amber-500/30 bg-gradient-to-br from-amber-50 via-white to-slate-50 p-6 sm:p-10 shadow-sm ring-1 ring-amber-500/15">
                        <div class="flex flex-col md:flex-row items-start gap-6 mb-8">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/30">
                                <span class="material-icons text-3xl" aria-hidden="true">check_circle</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Proposal approved</h3>
                                <p class="text-slate-800 font-semibold mt-1">{{ $u->project_title }}</p>
                                <p class="text-slate-600 text-sm mt-2 max-w-2xl">You are linked to your supervisor for this project. Submit new chapters below; you can revise any chapter until your supervisor marks it <span class="text-emerald-700 font-semibold">Approved</span> (then it locks).</p>
                            </div>
                        </div>

                        {{-- New chapter --}}
                        <div class="rounded-3xl border-2 border-dashed border-amber-400/50 bg-white p-6 sm:p-8 shadow-inner mb-10">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="material-icons text-amber-600" aria-hidden="true">upload_file</span>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Submit a new chapter</h4>
                            </div>
                            <form action="{{ route('chapter.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                                @csrf
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Chapter name</label>
                                    <input type="text" name="chapter_name" value="{{ old('chapter_name') }}" required placeholder="e.g. Chapter 2 — Methodology" class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-500 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/30" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">File (PDF or DOCX)</label>
                                    <input type="file" name="chapter_file" required accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="block w-full text-sm text-slate-800 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-500 file:px-4 file:py-2.5 file:text-xs file:font-black file:uppercase file:text-white hover:file:bg-amber-600 cursor-pointer" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Student notes <span class="text-slate-500 font-medium normal-case">(your supervisor sees this next to the file)</span></label>
                                    <textarea name="student_comment" rows="3" placeholder="Context, questions, or what changed in this draft…" class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-500 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/30">{{ old('student_comment') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-3.5 text-sm font-black uppercase tracking-widest text-white shadow-lg shadow-amber-500/25 hover:from-amber-600 hover:to-amber-700 transition">
                                    <span class="material-icons text-base" aria-hidden="true">cloud_upload</span>
                                    Upload chapter
                                </button>
                            </form>
                        </div>

                        {{-- Chapter timeline / accordion --}}
                        @if ($u->chapters->isNotEmpty())
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 px-1">
                                    <span class="material-icons text-slate-600 text-xl" aria-hidden="true">history</span>
                                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-600">Your chapters</h4>
                                </div>
                                <div class="relative pl-4 sm:pl-6 border-l-2 border-indigo-200/80 space-y-4">
                                    @foreach ($u->chapters as $ch)
                                        @php
                                            $editable = in_array($ch->status, ['pending', 'revision_requested'], true);
                                        @endphp
                                        <div class="relative pl-6 sm:pl-8" x-data="{ open: {{ $editable ? 'true' : 'false' }} }">
                                            <span class="absolute -left-[9px] sm:-left-[11px] top-3 h-4 w-4 rounded-full border-2 border-white shadow {{ $ch->status === 'approved' ? 'bg-emerald-500' : ($ch->status === 'revision_requested' ? 'bg-amber-500' : 'bg-indigo-500') }}"></span>

                                            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden ring-1 ring-slate-200/80">
                                                <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-4 px-4 py-4 text-left hover:bg-slate-50 transition">
                                                    <div class="min-w-0">
                                                        <p class="font-bold text-slate-900 truncate">{{ $ch->chapter_name }}</p>
                                                        <p class="text-xs text-slate-500 mt-0.5">Uploaded {{ $ch->created_at->format('M j, Y') }} · {{ $ch->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-2 shrink-0">
                                                        @if ($ch->status === 'pending')
                                                            <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-amber-900 ring-1 ring-amber-300">Pending</span>
                                                        @elseif ($ch->status === 'approved')
                                                            <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-900 ring-1 ring-emerald-300">Approved</span>
                                                            <span class="hidden sm:inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1 text-[10px] font-bold uppercase text-slate-600 ring-1 ring-slate-200">
                                                                <span class="material-icons text-xs" aria-hidden="true">lock</span> Locked
                                                            </span>
                                                        @elseif ($ch->status === 'revision_requested')
                                                            <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-amber-950 ring-1 ring-amber-400">Revision</span>
                                                        @endif
                                                        <span class="material-icons text-slate-400 transition" :class="open ? 'rotate-180' : ''" aria-hidden="true">expand_more</span>
                                                    </div>
                                                </button>

                                                <div x-show="open" class="border-t border-slate-200 bg-slate-50/80 px-4 py-5 space-y-5">
                                                    @if ($ch->student_comment)
                                                        <div class="rounded-xl border border-amber-300/60 bg-amber-50 px-4 py-3">
                                                            <p class="text-[10px] font-black uppercase tracking-widest text-amber-800 mb-1">Your notes to supervisor</p>
                                                            <p class="text-sm text-amber-950 leading-relaxed whitespace-pre-wrap">{{ $ch->student_comment }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($ch->supervisor_comment)
                                                        <div class="rounded-xl border border-indigo-300/70 bg-indigo-50 px-4 py-3">
                                                            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-800 mb-1">Supervisor feedback</p>
                                                            <p class="text-sm text-indigo-950 leading-relaxed whitespace-pre-wrap">{{ $ch->supervisor_comment }}</p>
                                                        </div>
                                                    @endif

                                                    <div class="flex flex-wrap gap-3">
                                                        <a href="{{ route('chapter.download', $ch) }}" class="inline-flex items-center gap-2 rounded-xl border border-indigo-300 bg-white px-4 py-2 text-xs font-black uppercase tracking-widest text-indigo-800 hover:bg-indigo-50">
                                                            <span class="material-icons text-sm" aria-hidden="true">download</span>
                                                            Download
                                                        </a>
                                                    </div>

                                                    @if ($editable)
                                                        <div class="rounded-2xl border border-indigo-200 bg-white p-5 shadow-sm">
                                                            <p class="text-xs font-bold text-slate-800 mb-4">Replace file or update notes — submitting returns status to <span class="text-amber-700">Pending</span> for your supervisor.</p>
                                                            <form action="{{ route('chapter.update', $ch) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="space-y-2">
                                                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Chapter name</label>
                                                                    <input type="text" name="chapter_name" value="{{ old('chapter_name', $ch->chapter_name) }}" required class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30" />
                                                                </div>
                                                                <div class="space-y-2">
                                                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">New file <span class="text-slate-500 font-medium normal-case">(optional)</span></label>
                                                                    <input type="file" name="chapter_file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="block w-full text-sm text-slate-800 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-600 file:px-4 file:py-2.5 file:text-xs file:font-black file:uppercase file:text-white hover:file:bg-amber-700 cursor-pointer" />
                                                                </div>
                                                                <div class="space-y-2">
                                                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Student notes</label>
                                                                    <textarea name="student_comment" rows="3" class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">{{ old('student_comment', $ch->student_comment) }}</textarea>
                                                                </div>
                                                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-600 px-6 py-3 text-xs font-black uppercase tracking-widest text-white hover:bg-amber-700 transition">
                                                                    <span class="material-icons text-sm" aria-hidden="true">save</span>
                                                                    Save revision
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <p class="text-sm text-slate-600 flex items-center gap-2">
                                                            <span class="material-icons text-slate-500 text-base" aria-hidden="true">info</span>
                                                            This chapter is approved and locked. Submit a new chapter above if you have more to add.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                @elseif ($proposalPending)
                    <div class="rounded-[40px] border border-amber-500/40 bg-amber-50 p-8 shadow-sm ring-1 ring-amber-500/20">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-md shadow-amber-500/30">
                                <span class="material-icons" aria-hidden="true">hourglass_empty</span>
                            </div>
                            <div>
                                <h3 class="text-amber-950 font-black uppercase text-[10px] tracking-widest">Proposal under review</h3>
                                <p class="text-amber-950 font-bold text-lg mt-1">{{ $u->project_title }}</p>
                                <p class="text-amber-900 text-sm mt-2">Your supervisor is reviewing your application. Chapter uploads unlock after approval.</p>
                            </div>
                        </div>
                    </div>

                @elseif ($needsProposalForm)
                    <div class="rounded-[40px] border border-amber-500/40 bg-gradient-to-br from-amber-50 to-white p-8 shadow-sm ring-1 ring-amber-500/25">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white">
                                <span class="material-icons" aria-hidden="true">assignment</span>
                            </div>
                            <div>
                                <h3 class="text-slate-900 font-black text-lg uppercase tracking-tight">Project proposal</h3>
                                <p class="text-slate-700 text-sm mt-1">
                                    @if ($proposalDeclined)
                                        Your previous proposal needs updates. Adjust the details below and resubmit.
                                    @else
                                        Choose a supervisor and describe your project to begin.
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border-2 border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('proposal.store') }}" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Supervisor</label>
                                <select name="supervisor_id" required class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-400/40">
                                    <option value="">— Select supervisor —</option>
                                    @foreach ($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}" @selected(old('supervisor_id', $u->supervisor_id) == $supervisor->id)>{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Project title</label>
                                <input name="project_title" required value="{{ old('project_title', $u->project_title) }}" class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-400/40" placeholder="Working title" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Project description</label>
                                <textarea name="project_description" rows="5" required class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-400/40" placeholder="Objectives, scope, and expected outcomes…">{{ old('project_description', $u->project_description) }}</textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-600 px-6 py-4 text-sm font-black uppercase tracking-widest text-white shadow-lg shadow-amber-600/25 hover:bg-amber-700 transition">
                                <span class="material-icons text-base" aria-hidden="true">send</span>
                                Submit proposal
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
