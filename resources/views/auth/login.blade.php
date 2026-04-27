<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>University Project Hub - Login</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3670e2",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111721",
                    },
                    fontFamily: { "display": ["Lexend"] }
                },
            },
        }
    </script>
</head>
<body class="flex items-center justify-center min-h-screen font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 overflow-hidden">

    <main class="flex w-full min-h-screen">
        <section class="relative flex-col items-center justify-center hidden w-1/2 p-12 lg:flex overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Campus Environment" class="object-cover w-full h-full"
                    src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop" />
                <div class="absolute inset-0 bg-gradient-to-br from-primary/80 via-primary/70 to-indigo-900/95 mix-blend-multiply"></div>
            </div>

            <div class="relative z-10 max-w-lg text-center">
                <div class="inline-flex items-center justify-center p-5 mb-8 border shadow-2xl bg-white/10 backdrop-blur-xl rounded-2xl border-white/20">
                    <img src="{{ asset('favicon.svg') }}" alt="ProjectHub Icon" class="h-12 w-12">
                </div>
                <h1 class="mb-6 text-5xl font-bold leading-tight text-white xl:text-6xl drop-shadow-lg">
                    Project_Hub
                </h1>
                <p class="text-xl font-light leading-relaxed text-white/90 drop-shadow">
                    The centralized platform for academic research, supervisor collaboration, and thesis tracking.
                </p>
            </div>

            <div class="absolute z-10 flex items-center justify-between text-xs bottom-8 left-8 right-8 text-white/60 font-medium tracking-widest uppercase">
                <span>© 2026 GLOBAL UNIVERSITY</span>
                <span class="flex items-center gap-2">
                    <span class="text-sm material-icons">verified_user</span>
                    Secure Academic Gateway
                </span>
            </div>
        </section>

        <section class="flex flex-col items-center justify-center w-full p-6 bg-white lg:w-1/2 dark:bg-background-dark shadow-2xl">
            <div class="w-full max-w-md">
                
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-8 lg:hidden">
                        <div class="flex items-center justify-center w-10 h-10 shadow-lg bg-primary rounded-xl">
                            <span class="text-xl text-white material-icons">school</span>
                        </div>
                        <span class="text-xl font-bold text-slate-800 dark:text-white">Project_Hub</span>
                    </div>
                    
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight mb-2">Welcome Back</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium italic">Authenticate to access your workspace.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-center gap-2 text-red-700 font-bold text-sm mb-1">
                            <span class="material-icons text-sm">error</span> Authentication Failed
                        </div>
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-xs">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-400" for="email">University Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                <span class="material-icons text-xl">alternate_email</span>
                            </div>
                            <input class="block w-full py-4 pl-12 pr-4 border-none rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all font-medium" 
                                id="email" name="email" type="email" placeholder="name@university.edu" required autofocus />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-400" for="password">Security Password</label>
                        </div>
                        <div class="relative group" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                <span class="material-icons text-xl">lock</span>
                            </div>
                            <input class="block w-full py-4 pl-12 pr-12 border-none rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all font-medium" 
                                id="password" name="password" type="password" placeholder="••••••••" required />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-primary transition-colors">
                                <span id="passwordToggleIcon" class="material-icons">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-300 text-primary focus:ring-primary/20 transition-all">
                            <span class="ml-2 text-sm font-semibold text-slate-500">Stay signed in</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-primary hover:underline transition-all" href="{{ route('password.request') }}">Recovery?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-3 bg-primary hover:bg-primary/90 text-white font-black uppercase tracking-widest text-xs py-5 px-6 rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 active:scale-[0.98]">
                        Log in to dashboard <span class="material-icons text-sm">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-sm font-semibold text-slate-400">
                        Institutional Access only. 
                        <a href="{{ route('register') }}" class="text-primary hover:underline ml-1">Request Account</a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                pwd.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>