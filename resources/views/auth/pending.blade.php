<body class="min-h-screen flex items-center justify-center p-6 bg-slate-950">
    <div class="max-w-md w-full bg-slate-900 border border-slate-800 p-12 rounded-[40px] text-center">
        <div class="w-20 h-20 bg-amber-500/10 rounded-3xl flex items-center justify-center mx-auto mb-8 animate-pulse">
            <span class="material-icons text-4xl text-amber-500">verified_user</span>
        </div>
        <h2 class="text-2xl font-black text-white mb-4 uppercase tracking-tight">Account Pending</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-8">
            Welcome to the Hub! Your account is currently under review by the University Admin. 
            You will gain access to your dashboard once your credentials are verified.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-amber-500 font-black text-xs uppercase tracking-widest hover:underline">
                Log Out & Check Later
            </button>
        </form>
    </div>
</body>