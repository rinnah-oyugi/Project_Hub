<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ProjectHub · Join the Stream</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    @php 
        $role = request('role', 'student');
        $isSupervisor = $role === 'supervisor';
        
        // Vibrant theme colors
        $themeColor = $isSupervisor ? '#6366f1' : '#f59e0b'; 
        $secondaryColor = $isSupervisor ? '#4338ca' : '#d97706';
        
        // The split background gradient
        $bgGradient = "linear-gradient(135deg, $secondaryColor 0%, $themeColor 50%, #ffffff 100%)";
    @endphp

    <style>
        body { 
            font-family: 'Lexend', sans-serif; 
            background: {!! $bgGradient !!};
            background-attachment: fixed;
            min-height: 100vh;
        }

        .hub-accent-dynamic { color: {{ $themeColor }}; }
        .bg-hub-accent-dynamic { background-color: {{ $themeColor }}; }
        
        input:focus, select:focus { 
            border-color: {{ $themeColor }} !important; 
            box-shadow: 0 0 0 4px {{ $themeColor }}1A; 
            outline: none;
        }

        /* Glassmorphism card effect */
        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 50px 100px -20px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>
<body class="flex items-center justify-center p-6">

    <div class="w-full max-w-[650px] registration-card rounded-[40px] p-10 lg:p-14 transition-all duration-700">
        
        <div class="text-center mb-10">
            <div class="inline-flex p-3 bg-white shadow-lg rounded-2xl mb-6">
                <img src="{{ asset('favicon.svg') }}" alt="ProjectHub Icon" class="h-8 w-8">
            </div>
            
            <div class="mb-4">
                <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full border border-slate-200 bg-slate-50 text-slate-500">
                    {{ $isSupervisor ? 'Faculty Member' : 'Academic Student' }}
                </span>
            </div>

            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Create Account</h1>
            <p class="text-slate-500 mt-2 font-medium">
                Registering for the <span class="hub-accent-dynamic font-black uppercase">{{ $role }} stream</span>
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-900">
                <p class="font-black uppercase text-[10px] tracking-widest text-amber-800 mb-2">Please fix the following</p>
                <ul class="list-disc list-inside space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                        <input name="name" required class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="Riina Ochieng" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">University ID / Staff ID</label>
                        <input name="university_id" required class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="e.g. 2024-HUB-001" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">University Email Address</label>
                    <input name="email" type="email" required class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="name@university.edu" />
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Department</label>
                    <select name="department" class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all appearance-none cursor-pointer">
                        <option value="Computer Science">Computer Science</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Business">Business</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                    <input name="phone" type="tel" class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="+254 712 345 678" />
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Address</label>
                    <textarea name="address" rows="2" class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all resize-none" placeholder="Campus Address, Room Number"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Emergency Contact</label>
                        <input name="emergency_contact" type="text" class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="Parent/Guardian Name" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Emergency Phone</label>
                        <input name="emergency_phone" type="tel" class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" placeholder="+254 712 345 678" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                        <input name="password" type="password" required class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Password</label>
                        <input name="password_confirmation" type="password" required class="w-full px-5 py-4 border border-slate-200 rounded-2xl bg-white transition-all" />
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-hub-accent-dynamic text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-xl hover:opacity-90 transition-all transform hover:-translate-y-1 shadow-{{ $isSupervisor ? 'indigo' : 'amber' }}-500/20">
                    Complete Registration
                </button>
                
                <div class="mt-8 flex items-center justify-center gap-2">
                    <span class="text-sm text-slate-400 font-medium">Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-sm font-black hub-accent-dynamic hover:underline uppercase tracking-widest">Log In</a>
                </div>
            </div>
        </form>

        <p class="mt-10 text-[10px] text-center text-slate-400 uppercase tracking-widest font-bold">
            &copy; 2026 ProjectHub Hub · academic excellence
        </p>
    </div>

</body>
</html>