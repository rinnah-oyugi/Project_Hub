<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account pending · ProjectHub</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-slate-950">
    <div class="max-w-md w-full bg-slate-900 border border-slate-800 p-12 rounded-[40px] text-center">
        <div class="w-20 h-20 bg-amber-500/10 rounded-3xl flex items-center justify-center mx-auto mb-8 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-white mb-4 uppercase tracking-tight">Account pending</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-6">
            Welcome to the Hub. Your account is under review by the university admin.
            You will get full access once your credentials are verified.
        </p>
        <div class="mb-8 rounded-2xl border border-indigo-500/25 bg-indigo-950/40 px-4 py-3 text-left text-xs text-slate-400 ring-1 ring-amber-500/15">
            <span class="font-black uppercase tracking-widest text-amber-400/90">Connection tip</span>
            <p class="mt-2 leading-relaxed">
                If this page was slow to appear or looked empty for a moment, wait a few seconds and refresh — local sessions sometimes need an extra beat to sync after login or registration.
            </p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-amber-500 font-black text-xs uppercase tracking-widest hover:underline">
                Log out and check later
            </button>
        </form>
    </div>
</body>
</html>
