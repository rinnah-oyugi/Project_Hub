<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight tracking-tight ">
                    {{ __('SUPERVISOR HUB') }}
                </h2>
                <p class="text-slate-500 text-xs mt-1 font-medium uppercase tracking-widest">Research & Project Management</p>
            </div>
            <div class="hidden md:flex flex-col text-right">
                <span class="text-emerald-400 font-black tracking-widest uppercase text-sm">{{ Auth::user()->name }}</span>
                <span class="text-indigo-400 text-xs font-medium uppercase tracking-tighter">Project Supervisor</span>
            </div>
        </div>
    </x-slot>

    @php
        $approvedStudents = $students->where('request_status', 'approved');
        $approvedChapterCount = $approvedStudents->sum(fn ($s) => $s->chapters->where('status', 'approved')->count());
    @endphp

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Search Bar -->
            <div class="bg-slate-900 rounded-3xl border border-indigo-500/30 p-6">
                <form id="searchForm" onsubmit="searchStudent(event)" class="flex items-center gap-4">
                    <div class="flex-1 relative">
                        <span class="material-icons absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">badge</span>
                        <input type="text" 
                               id="studentSearch" 
                               name="university_id"
                               placeholder="Search students by University ID..." 
                               class="w-full pl-12 pr-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent">
                    </div>
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition-colors font-black uppercase tracking-wider text-xs">
                        Search
                    </button>
                </form>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-red-500/40 bg-red-950/50 px-6 py-4 text-sm text-red-100">
                    <p class="font-black uppercase text-[10px] tracking-widest text-red-300 mb-2">Could not save feedback</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900 p-8 rounded-3xl border border-indigo-500/30">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Active Students</p>
                    <h3 class="text-5xl font-black text-white mt-2">{{ $students?->where('request_status', 'approved')?->count() ?? 0 }}</h3>
                </div>
                <div class="bg-slate-900 p-8 rounded-3xl border border-indigo-500/30">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Pending Proposals</p>
                    <h3 class="text-5xl font-black text-amber-500 mt-2">{{ $students?->where('request_status', 'pending')?->count() ?? 0 }}</h3>
                </div>
                <div class="bg-slate-900 p-8 rounded-3xl border border-indigo-500/30">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-widest">Approved Chapters</p>
                    <h3 class="text-5xl font-black text-emerald-400 mt-2">{{ $approvedChapterCount ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-slate-900 shadow-2xl rounded-3xl border border-indigo-500/30 overflow-hidden ring-1 ring-indigo-500/15">
                <div class="px-8 py-6 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">Incoming Student Requests</h3>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-800/50">
                        @forelse($students?->where('request_status', 'pending') as $student)
                        <tr class="hover:bg-slate-800/30" data-university-id="{{ $student->university_id ?? '' }}">
                            <td class="px-8 py-6 text-white font-bold">
                                <div class="flex items-center gap-2">
                                    {{ $student->name ?? 'Unknown Student' }}
                                    @if($student->university_id)
                                        <span class="text-xs text-indigo-400 font-mono bg-indigo-900/50 px-2 py-1 rounded">{{ $student->university_id }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div>
                                    <p class="text-slate-300 text-sm font-medium">{{ $student->project_title ?? 'No Project Title' }}</p>
                                    @if($student->project_description)
                                        <p class="text-slate-500 text-xs mt-2">{{ substr($student->project_description ?? '', 0, 150) }}{{ strlen($student->project_description ?? '') > 150 ? '...' : '' }}</p>
                                    @endif
                                    @if($student->proposal_student_comment)
                                        <div class="mt-3 p-3 bg-amber-950/30 border border-amber-500/40 rounded-xl">
                                            <p class="text-xs text-amber-300 font-semibold mb-1">Student Comments:</p>
                                            <p class="text-xs text-amber-100">{{ $student->proposal_student_comment }}</p>
                                        </div>
                                    @endif
                                    @if($student->proposal_supervisor_comment)
                                        <div class="mt-3 p-3 bg-indigo-950/30 border border-indigo-500/40 rounded-xl">
                                            <p class="text-xs text-indigo-300 font-semibold mb-1">Your Feedback:</p>
                                            <p class="text-xs text-indigo-100">{{ $student->proposal_supervisor_comment }}</p>
                                        </div>
                                    @endif
                                    @if($student->proposal_file_path)
                                        <a href="{{ Storage::url($student->proposal_file_path) }}" 
                                           download="proposal_{{ $student->name }}_{{ $student->id }}.{{ pathinfo($student->proposal_file_path, PATHINFO_EXTENSION) }}"
                                           class="inline-flex items-center gap-1 mt-2 text-xs text-indigo-400 hover:text-indigo-300 transition-colors">
                                            <span class="material-icons text-sm">download</span>
                                            Download Proposal
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="space-y-3">
                                    <!-- Download Button -->
                                    @if($student->proposal_file_path)
                                        <a href="{{ Storage::url($student->proposal_file_path) }}" 
                                           download="proposal_{{ $student->name }}_{{ $student->id }}.{{ pathinfo($student->proposal_file_path, PATHINFO_EXTENSION) }}"
                                           class="inline-flex items-center gap-1 px-3 py-2 bg-amber-600 text-white rounded-xl text-xs font-black uppercase hover:bg-amber-700 transition-colors">
                                            <span class="material-icons text-sm">download</span>
                                            Download
                                        </a>
                                    @endif
                                    
                                    <!-- Feedback Form -->
                                    <form action="{{ route('proposal.feedback', $student->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <select name="proposal_status" class="flex-1 px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-xs focus:ring-2 focus:ring-indigo-500/50">
                                                <option value="pending" {{ $student->proposal_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $student->proposal_status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $student->proposal_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded-lg text-xs font-black uppercase hover:bg-indigo-700 transition-colors">
                                                Update
                                            </button>
                                        </div>
                                        <textarea name="proposal_supervisor_comment" 
                                                  placeholder="Add feedback..." 
                                                  rows="2"
                                                  class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-xs placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/50 resize-none">{{ $student->proposal_supervisor_comment }}</textarea>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td class="px-8 py-10 text-center text-slate-500 italic">No pending requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-900 shadow-2xl rounded-3xl border border-indigo-500/30 overflow-hidden ring-1 ring-indigo-500/15">
                <div class="px-8 py-6 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white">Student chapters &amp; feedback</h3>
                    <p class="text-slate-500 text-sm mt-1">Each card is one upload. Edit the comment and status, then submit.</p>
                </div>
                <div class="p-8 space-y-12">
                    @forelse($approvedStudents as $student)
                        <div class="space-y-6 rounded-3xl border border-slate-800 bg-slate-950/40 p-6 sm:p-8">
                            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-slate-800 pb-4">
                                <div>
                                    <h4 class="text-white font-black text-xl">{{ $student->name }}</h4>
                                    <p class="text-indigo-400 text-sm font-medium">{{ $student->project_title ?? '—' }}</p>
                                    <p class="text-slate-500 text-xs mt-2 uppercase tracking-widest font-bold">Proposal: <span class="text-slate-400">{{ $student->request_status }}</span></p>
                                    
                                    <!-- Student Contact Details -->
                                    <div class="mt-3 space-y-1">
                                        @if($student->email)
                                            <p class="text-xs text-slate-400">
                                                <span class="material-icons text-xs align-middle mr-1">email</span>
                                                {{ $student->email }}
                                            </p>
                                        @endif
                                        @if($student->university_id)
                                            <p class="text-xs text-indigo-400 font-mono">
                                                <span class="material-icons text-xs align-middle mr-1">badge</span>
                                                {{ $student->university_id }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @forelse($student->chapters as $chapter)
                                <div class="rounded-2xl border border-indigo-500/25 bg-slate-900 p-6 space-y-5 shadow-md shadow-black/20">
                                    <div class="flex flex-wrap items-start justify-between gap-4">
                                        <div>
                                            <p class="text-white font-bold text-lg">{{ $chapter->chapter_name }}</p>
                                            <p class="text-slate-500 text-xs mt-1">Submitted {{ $chapter->created_at->diffForHumans() }}</p>
                                            @if($chapter->student_comment)
                                                <div class="mt-4 rounded-xl border-2 border-amber-500/40 bg-amber-950/30 p-4 ring-1 ring-amber-500/20">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-300 mb-2 flex items-center gap-1">
                                                        <span class="material-icons text-sm" aria-hidden="true">sticky_note_2</span>
                                                        Student notes <span class="text-amber-200/80 font-medium normal-case">(submitted with this upload)</span>
                                                    </p>
                                                    <p class="text-sm text-amber-50 leading-relaxed whitespace-pre-wrap">{{ $chapter->student_comment }}</p>
                                                </div>
                                            @else
                                                <p class="text-slate-600 text-xs mt-3 italic">No student notes for this upload.</p>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($chapter->status === 'pending')
                                                <span class="inline-flex items-center rounded-full bg-amber-500/15 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-400 ring-1 ring-amber-500/40">Pending</span>
                                            @elseif($chapter->status === 'approved')
                                                <span class="inline-flex items-center rounded-full bg-emerald-600/20 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-300 ring-1 ring-emerald-500/50">Approved</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-amber-500/20 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-200 ring-1 ring-amber-400/50">Revision requested</span>
                                            @endif
                                            <a href="{{ route('chapter.download', $chapter) }}" class="text-xs font-black uppercase tracking-widest text-indigo-400 hover:text-indigo-300">Download</a>
                                        </div>
                                    </div>

                                    @if($chapter->status === 'approved')
                                        <div class="rounded-2xl border border-amber-500/35 bg-amber-950/25 p-5 ring-1 ring-amber-500/20">
                                            <div class="flex items-start gap-3 mb-4">
                                                <span class="material-icons text-amber-400 shrink-0" aria-hidden="true">lock_open</span>
                                                <div>
                                                    <p class="text-sm font-bold text-amber-100">Re-open for revision</p>
                                                    <p class="text-xs text-amber-200/80 mt-1 leading-relaxed">This removes the student lock so they can replace the file or update notes. Status becomes <span class="font-semibold text-amber-300">Revision requested</span>.</p>
                                                </div>
                                            </div>
                                            <form action="{{ route('chapter.reopen', $chapter) }}" method="POST" class="space-y-3">
                                                @csrf
                                                <div>
                                                    <label class="text-[10px] font-black text-amber-300/90 uppercase tracking-widest">Optional note to student</label>
                                                    <textarea name="comment" rows="2" class="w-full mt-2 bg-slate-900 border border-amber-600/40 rounded-xl text-amber-50 text-sm p-3 placeholder:text-amber-200/40 focus:ring-amber-500 focus:border-amber-500" placeholder="e.g. Council asked for an extra subsection in section 3…"></textarea>
                                                </div>
                                                <button type="submit" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto rounded-xl bg-amber-600 px-5 py-3 text-xs font-black uppercase tracking-widest text-amber-950 hover:bg-amber-500 transition ring-1 ring-amber-400/50">
                                                    <span class="material-icons text-sm" aria-hidden="true">undo</span>
                                                    Re-open chapter
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <form action="{{ route('chapter.feedback', $chapter) }}" method="POST" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-950/50 p-5">
                                        @csrf
                                        <div>
                                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Supervisor comment</label>
                                            <textarea name="comment" rows="4" class="w-full mt-2 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Feedback for this chapter…">{{ old('comment', $chapter->supervisor_comment) }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                            <div>
                                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</label>
                                                <select name="status" required class="w-full mt-2 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm py-3 px-3 focus:ring-indigo-500">
                                                    <option value="pending" @selected(old('status', $chapter->status) === 'pending')>Pending</option>
                                                    <option value="revision_requested" @selected(old('status', $chapter->status) === 'revision_requested')>Revision Requested</option>
                                                    <option value="approved" @selected(old('status', $chapter->status) === 'approved')>Approved</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase py-4 rounded-xl text-xs tracking-widest shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 transition">
                                                Submit feedback
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm italic">No chapter uploads for this student yet.</p>
                            @endforelse
                        </div>
                    @empty
                        <p class="text-center text-slate-500 italic">No approved students yet — approve proposals above to unlock chapter reviews.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
function searchStudent(event) {
    event.preventDefault();
    
    const searchValue = document.getElementById('studentSearch').value.trim();
    
    if (!searchValue) {
        alert('Please enter a University ID to search');
        return;
    }
    
    // Find student in current list
    const studentRows = document.querySelectorAll('tbody tr');
    let foundStudent = null;
    
    studentRows.forEach(row => {
        const universityId = row.getAttribute('data-university-id');
        if (universityId && universityId.toLowerCase().includes(searchValue.toLowerCase())) {
            foundStudent = row;
            // Show row and scroll to it
            row.style.display = '';
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Highlight row temporarily
            row.classList.add('bg-amber-950/50', 'ring-2', 'ring-amber-500');
            setTimeout(() => {
                row.classList.remove('bg-amber-950/50', 'ring-2', 'ring-amber-500');
            }, 3000);
        } else {
            row.style.display = 'none';
        }
    });
    
    if (!foundStudent) {
        alert('No student found with University ID: ' + searchValue);
        // Show all rows again
        studentRows.forEach(row => {
            row.style.display = '';
        });
    }
}

function filterStudents() {
    const searchValue = document.getElementById('studentSearch').value.toLowerCase();
    const studentRows = document.querySelectorAll('tbody tr');
    
    studentRows.forEach(row => {
        const universityId = row.getAttribute('data-university-id');
        if (universityId && universityId.toLowerCase().includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Add event listener for search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterStudents);
    }
});
</script>
