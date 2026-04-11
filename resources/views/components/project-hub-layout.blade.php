<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Project Hub' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    
    <style>
        body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; padding: 0; }
        .bg-primary { background-color: #3670e2; }
        .text-primary { color: #3670e2; }
    </style>
</head>
<body class="font-display bg-slate-50 text-slate-800">

    <div class="flex w-full h-screen overflow-hidden bg-white">

        <div class="relative flex-col justify-between hidden overflow-hidden md:flex md:w-1/2 bg-primary">
            <div class="relative z-10 flex flex-col h-full p-12 xl:p-16">
                <div class="flex items-center gap-3 mb-12">
                    <div class="p-3 bg-white rounded-2xl">
                        <span class="text-3xl material-icons text-primary">{{ $icon ?? 'hub' }}</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-white">Project Hub</span>
                </div>

                <div class="max-w-xl mt-8">
                    <h2 class="mb-6 text-5xl font-bold leading-tight text-white">{{ $sidebarHeading ?? 'Final Step.' }}<br>{{ $sidebarSubheading ?? 'Submit your idea.' }}</h2>
                    <p class="text-xl text-white/80">
                        {{ $sidebarText ?? 'Connect with supervisors, track milestones, and access resources — all in one place.' }}
                    </p>
                </div>

                <div class="mt-auto mb-10 text-white/70 text-sm italic">
                    "Precision and progress in every chapter."
                </div>
                
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary to-indigo-900 opacity-95"></div>
            </div>
        </div>

        <div class="flex flex-col w-full overflow-y-auto bg-white md:w-1/2">
            <div class="flex-1 p-8 lg:p-12 xl:p-16">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>