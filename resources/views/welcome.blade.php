<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProjectHub | Research Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; }
        .amber-sunset {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #4338ca 100%);
        }
        .amber-card-btn:hover { background-color: #d97706; }
        .indigo-card-btn:hover { background-color: #3730a3; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <nav class="flex items-center justify-between px-10 py-6 bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <div class="p-2 bg-amber-500 rounded-lg shadow-lg shadow-amber-500/20">
                <span class="material-icons text-white">hub</span>
            </div>
            <span class="text-xl font-black tracking-tighter text-slate-900 uppercase">ProjectHub</span>
        </div>
        <div>
            <a href="#onboarding" class="px-6 py-3 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-amber-600 transition-all">Get Started</a>
        </div>
    </nav>

    <header class="amber-sunset py-32 px-10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <h1 class="text-7xl md:text-8xl font-black text-white leading-none mb-8 tracking-tighter">
                Research.<br><span class="opacity-50">Simplified.</span>
            </h1>
            <p class="text-white/80 text-xl max-w-2xl mx-auto mb-12 font-medium">
                The ultimate workspace for final year students and faculty supervisors to collaborate on thesis projects.
            </p>
            <div class="flex justify-center gap-4">
                 <a href="#onboarding" class="px-10 py-5 bg-white text-indigo-900 font-black rounded-2xl shadow-2xl hover:scale-105 transition-transform">Begin Your Journey</a>
            </div>
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-900/40 rounded-full blur-3xl"></div>
    </header>

    <section id="onboarding" class="py-32 px-10 max-w-7xl mx-auto text-center">
        <h2 class="text-4xl font-black text-slate-900 mb-4 uppercase tracking-tight">Choose Your Path</h2>
        <p class="text-slate-500 mb-16">Select your role to register or log in to your dashboard.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-12 rounded-[40px] border border-slate-100 shadow-xl hover:shadow-2xl transition-all group">
                <div class="w-20 h-20 bg-amber-100 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:bg-amber-500 transition-colors">
                    <span class="material-icons text-4xl text-amber-600 group-hover:text-white">school</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-4">I am a Student</h3>
                <p class="text-slate-500 mb-10 text-sm">Submit proposals, upload chapters, and receive real-time feedback from your supervisor.</p>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('register', ['role' => 'student']) }}" class="block px-8 py-4 bg-amber-500 text-white font-black rounded-xl uppercase text-xs tracking-widest shadow-lg shadow-amber-500/30 amber-card-btn transition-all">Register as Student</a>
                    <a href="{{ route('login') }}" class="block px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-xl uppercase text-xs tracking-widest hover:bg-slate-200 transition-all">Student Log In</a>
                </div>
            </div>

            <div class="bg-white p-12 rounded-[40px] border border-slate-100 shadow-xl hover:shadow-2xl transition-all group">
                <div class="w-20 h-20 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:bg-indigo-600 transition-colors">
                    <span class="material-icons text-4xl text-indigo-600 group-hover:text-white">psychology</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-4">I am a Supervisor</h3>
                <p class="text-slate-500 mb-10 text-sm">Manage student allocations, review research topics, and provide structured feedback.</p>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('register', ['role' => 'supervisor']) }}" class="block px-8 py-4 bg-indigo-600 text-white font-black rounded-xl uppercase text-xs tracking-widest shadow-lg shadow-indigo-600/30 indigo-card-btn transition-all">Register as Supervisor</a>
                    <a href="{{ route('login') }}" class="block px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-xl uppercase text-xs tracking-widest hover:bg-slate-200 transition-all">Supervisor Log In</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-10 text-center text-slate-400 text-xs uppercase tracking-widest">
        &copy; 2026 ProjectHub Hub · Built for Academic Excellence
    </footer>

</body>
</html>