<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Project Hub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-200">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/5 border-b border-white/10 backdrop-blur-md sticky top-0 z-50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0 flex-1">
                            {{ $header }}
                        </div>
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-500/35 bg-red-500/10 px-4 py-2.5 text-sm font-bold text-red-200 hover:bg-red-500/20 hover:border-red-400/50 transition whitespace-nowrap">
                                    <span class="material-icons text-lg leading-none">logout</span>
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </header>
            @endisset

            <main>
                @if (session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="flex items-start gap-3 rounded-2xl border border-emerald-500/35 bg-emerald-950/50 px-5 py-4 shadow-lg shadow-emerald-900/10">
                            <span class="material-icons text-emerald-400 shrink-0" aria-hidden="true">check_circle</span>
                            <p class="text-sm font-semibold text-emerald-100 leading-relaxed">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="flex items-start gap-3 rounded-2xl border border-red-500/35 bg-red-950/50 px-5 py-4 shadow-lg shadow-red-900/10">
                            <span class="material-icons text-red-400 shrink-0" aria-hidden="true">error</span>
                            <p class="text-sm font-semibold text-red-100 leading-relaxed">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>