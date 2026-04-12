<x-project-hub-layout>
    <x-slot name="title">Submit Proposal | Project Hub</x-slot>
    <x-slot name="icon">assignment</x-slot>
    <x-slot name="sidebarHeading">Pitch your</x-slot>
    <x-slot name="sidebarSubheading">Innovation.</x-slot>
    <x-slot name="sidebarText">Select your supervisor and define your project scope. Your journey to graduation starts with this single submission.</x-slot>

    <div class="mb-10">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold tracking-wider uppercase text-primary">Onboarding · Step 2</span>
            <span class="text-xs font-medium text-slate-400">Proposal Submission</span>
        </div>
        <div class="w-full h-2.5 rounded-full bg-slate-100">
            <div class="w-full h-full rounded-full bg-primary"></div>
        </div>
    </div>

    <h1 class="mb-3 text-3xl font-bold text-slate-900">Project Details</h1>
    <p class="mb-8 text-lg text-slate-500">Provide the core details of your research project for supervisor review.</p>

    @if ($errors->any())
        <div class="p-4 mb-6 text-red-700 bg-red-50 border-l-4 border-red-500 rounded-md">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('proposal.store') }}" class="space-y-8 pb-32">
        @csrf
        
        <section class="space-y-4">
            <h4 class="text-xs font-semibold tracking-wider uppercase text-slate-400">1 · Supervision</h4>
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Available Supervisors</label>
                <select name="supervisor_id" required class="w-full px-5 py-4 transition-all border-none rounded-xl bg-slate-50 focus:ring-2 focus:ring-primary/40 text-slate-900">
                    <option value="">-- Choose a Lecturer --</option>
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">Dr. {{ $supervisor->name }}</option>
                    @endforeach
                </select>
            </div>
        </section>

        <section class="space-y-6">
            <h4 class="text-xs font-semibold tracking-wider uppercase text-slate-400">2 · Project Definition</h4>
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Project Title</label>
                <input name="project_title" required class="w-full px-5 py-4 border-none rounded-xl bg-slate-50 focus:ring-2 focus:ring-primary/40 text-slate-900" placeholder="e.g. AI-Driven Waste Management System" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Project Description</label>
                <textarea name="project_description" rows="5" required class="w-full px-5 py-4 border-none rounded-xl bg-slate-50 focus:ring-2 focus:ring-primary/40 text-slate-900" placeholder="Summarize your project objectives..."></textarea>
            </div>
        </section>

        <div class="pt-6">
            <button type="submit" class="flex items-center justify-center w-full gap-3 px-10 py-5 text-lg font-bold text-white transition-all shadow-lg rounded-xl bg-primary hover:bg-primary/90 shadow-primary/30 hover:-translate-y-1">
                Submit Proposal <span class="material-icons">rocket_launch</span>
            </button>
        </div>
    </form>

    <div class="absolute bottom-10 left-10 z-50">
        <a href="/" class="group flex items-center gap-3 px-6 py-3 bg-indigo-50 border border-indigo-100 rounded-full shadow-lg hover:shadow-indigo-500/10 hover:border-indigo-200 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 group-hover:text-indigo-600 group-hover:-translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            
            <span class="text-indigo-700 group-hover:text-indigo-900 font-black uppercase text-xs tracking-[0.15em] transition-colors">
                Back to Welcome
            </span>
        </a>
    </div>
</x-project-hub-layout>