<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Department Configuration - Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3670e2",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111721",
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 min-h-screen">
<!-- Navigation Sidebar (Mini) -->
<aside class="fixed left-0 top-0 h-full w-20 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col items-center py-6 gap-8 z-50">
<div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
<span class="material-icons">school</span>
</div>
<nav class="flex flex-col gap-6">
<button class="p-3 rounded-lg text-slate-400 hover:text-primary transition-colors">
<span class="material-icons">dashboard</span>
</button>
<button class="p-3 rounded-lg bg-primary/10 text-primary">
<span class="material-icons">account_balance</span>
</button>
<button class="p-3 rounded-lg text-slate-400 hover:text-primary transition-colors">
<span class="material-icons">people</span>
</button>
<button class="p-3 rounded-lg text-slate-400 hover:text-primary transition-colors">
<span class="material-icons">assignment</span>
</button>
<button class="p-3 rounded-lg text-slate-400 hover:text-primary transition-colors">
<span class="material-icons">settings</span>
</button>
</nav>
</aside>
<!-- Main Content Area -->
<main class="ml-20 p-8 max-w-[1600px] mx-auto">
<!-- Top Action Bar -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
<div>
<nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
<span>Admin</span>
<span class="material-icons text-xs">chevron_right</span>
<span class="text-primary font-medium">Department Setup</span>
</nav>
<h1 class="text-3xl font-bold tracking-tight">Department Configuration</h1>
</div>
<div class="flex items-center gap-4">
<div class="relative group">
<span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
<input class="pl-10 pr-4 py-2.5 w-64 rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Search departments..." type="text"/>
</div>
<button class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-lg shadow-primary/20">
<span class="material-icons text-sm">add</span>
<span>Create New Department</span>
</button>
</div>
</header>
<div class="grid grid-cols-12 gap-8">
<!-- Left Grid: Department Cards -->
<div class="col-span-12 xl:col-span-8">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<!-- Card: Computer Science -->
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 hover:shadow-xl hover:shadow-primary/5 transition-all group">
<div class="flex justify-between items-start mb-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
<span class="material-icons">terminal</span>
</div>
<div>
<h3 class="font-bold text-lg">Computer Science</h3>
<span class="text-xs font-semibold uppercase tracking-wider text-slate-400">CS - Faculty of IT</span>
</div>
</div>
<button class="text-slate-400 hover:text-primary p-1">
<span class="material-icons">more_vert</span>
</button>
</div>
<div class="grid grid-cols-3 gap-4 mb-6">
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">42</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Projects</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">15</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Supervisors</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">120</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Students</div>
</div>
</div>
<div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
<div class="flex -space-x-2">
<img alt="Head" class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900" data-alt="Portrait of a faculty head" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmbqV7puRRjCH4bsbxzWvFBwrTQqhaF-JlRI0VWh19xtfN-fsdGWk5XSBSNem_GEqs7pxf-Uy3Ik6sn-Z3w3CmLCd3XouTmh6fUvCBlCJzoYfJskfmG08_0nShhjqmakQd03KnagHXqAu1MPB1x1_OEgsMMwjM2UYXDrDeduvEn51qZ5MisSV_iq3wquX2GMP6S3A307pp5vOYyRAERHFtPbxb3KI1ZmQciNQOI52P0keowqKYPZRfYAaSFsG6fc-d5Hq0hdcoX0w"/>
<img alt="Staff" class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900" data-alt="Portrait of a staff member" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfNif2GtlwRGBX-qubg9sMuRx38wAMARQrvvDeK3CwlvgV3E5NqcO5kjk7WNAQO5vEQYYoPJK_OI20nGcNVqfWewsl0C2FLhSmpCfVYtB1FzA0INuGDxcMHItBEdSU1LnPL61QEnwYipNOyd8mqYHmRko47Gs6BTYXt1tyD-hCh1sKWaToB-XtJ_Qi8KREh0hkQ_eOJCIq-7ZhdZj36yay-IxPoh6hu3qr3kLnEEs-j7TNzQY04Idl58o1NmVSv4vYpwGWypLlus4"/>
<div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">+13</div>
</div>
<button class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                                Manage Dept <span class="material-icons text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- Card: Mechanical Engineering -->
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 hover:shadow-xl hover:shadow-primary/5 transition-all">
<div class="flex justify-between items-start mb-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-lg flex items-center justify-center">
<span class="material-icons">precision_manufacturing</span>
</div>
<div>
<h3 class="font-bold text-lg">Mechanical Engineering</h3>
<span class="text-xs font-semibold uppercase tracking-wider text-slate-400">ME - Faculty of Engineering</span>
</div>
</div>
<button class="text-slate-400 hover:text-primary p-1">
<span class="material-icons">more_vert</span>
</button>
</div>
<div class="grid grid-cols-3 gap-4 mb-6">
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">28</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Projects</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">12</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Supervisors</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">85</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Students</div>
</div>
</div>
<div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
<div class="flex -space-x-2">
<img alt="Head" class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900" data-alt="Portrait of an engineering professor" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBAXgrxm1Nyd6C7OoNPnVGiWiT6kgzyFj1i61ScrvroIQLjWaQNiv9PSfJZXVy-bHJXoeKg366z_sQmgbwDx4K8Lo0Ob-nv6-K7fy5EFRJf7LEr5M0hE2CO8sN7ltgLxfKVsdq0eZWfDaEdx1cKdtw3NlygKwx_McBuhk3XrOzY0s5FvbgQBF2kqVKqpvbQUSoJDZGM9tPgc_1kdVth43T2SrZdA79LXe76S2yunCG26uJt438FnsRWtUMNPn17904J0xhpyStRED8"/>
<div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">+11</div>
</div>
<button class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                                Manage Dept <span class="material-icons text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- Card: Business Administration -->
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 hover:shadow-xl hover:shadow-primary/5 transition-all">
<div class="flex justify-between items-start mb-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 rounded-lg flex items-center justify-center">
<span class="material-icons">business_center</span>
</div>
<div>
<h3 class="font-bold text-lg">Business Admin</h3>
<span class="text-xs font-semibold uppercase tracking-wider text-slate-400">BA - Faculty of Commerce</span>
</div>
</div>
<button class="text-slate-400 hover:text-primary p-1">
<span class="material-icons">more_vert</span>
</button>
</div>
<div class="grid grid-cols-3 gap-4 mb-6">
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">56</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Projects</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">22</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Supervisors</div>
</div>
<div class="text-center p-3 bg-background-light dark:bg-slate-800 rounded-lg">
<div class="text-xl font-bold text-primary">210</div>
<div class="text-[10px] uppercase font-bold text-slate-500">Students</div>
</div>
</div>
<div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
<div class="flex -space-x-2">
<img alt="Head" class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900" data-alt="Portrait of a female business dean" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUN5lkwTNspdVEy2Bom3_Eo2dTU3m-IVG1Jzeh8oIJKbYvD1VIFujifET40xnAwA_Xw5Xe326BUIldnizm2CtkxyskTi-fkCzjkOhs-_nGYoCtFOv8GH7dgGAI7si5ZV3Gol-r-meLEZYKYzI6WKsrbnrZyL67bTno8BLoQHks82tHY3gic_CPrf3mhsVC8apZPwFjknrRPfa_2groV6LsEXXeIsBfD5VVMBGgByJH66cTRZ5HkYMMj6AqmORJIZ5NcT1TwreUfFQ"/>
<img alt="Staff" class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900" data-alt="Portrait of a business professor" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6HMg3aMycgwyR0di_voIdQFUnFHl5mgl-iD0LioIOZ0PRZ4DJUa98V-XWowWC_zlOmn0yK8mU-FenpzTautulKVywoBiLpAE76qqKkBChnspVLIRVk4i9uVNrXS-HqIA7wOIm3zVQ-baqU6cj1YNjpnnBQn1vjTT4W2Jd3AWK8ig2Bs40i0cs2-pvSJT7TFuaplDyewrGuJ29Uox1uaLwkMD1CM1BqNe0YEjX2t33avD_a9Sl68mEsdVLUrafDEF6-BpgnaPydqo"/>
<div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">+20</div>
</div>
<button class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                                Manage Dept <span class="material-icons text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- Placeholder/Empty Add Card -->
<button class="border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl p-6 flex flex-col items-center justify-center text-slate-400 hover:border-primary hover:text-primary transition-all group min-h-[250px]">
<div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 group-hover:bg-primary/10 flex items-center justify-center mb-4 transition-colors">
<span class="material-icons text-3xl">add</span>
</div>
<span class="font-semibold text-lg">Add New Faculty</span>
<p class="text-xs text-center px-8 mt-2 opacity-60">Expand your institution by adding a new academic unit</p>
</button>
</div>
</div>
<!-- Right Sidebar: Faculty-Specific Settings -->
<div class="col-span-12 xl:col-span-4">
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 sticky top-8">
<div class="flex items-center gap-2 mb-6">
<span class="material-icons text-primary">tune</span>
<h2 class="text-xl font-bold">Global Requirements</h2>
</div>
<p class="text-sm text-slate-500 mb-8 leading-relaxed">
                        Define project-level rules and requirements applied to all departments. These settings ensure institutional standards are met.
                    </p>
<div class="space-y-6">
<!-- Toggle Group 1 -->
<div class="space-y-4">
<h4 class="text-xs font-bold uppercase tracking-widest text-slate-400">Submission Policies</h4>
<div class="flex items-center justify-between p-3 bg-background-light dark:bg-slate-800/50 rounded-lg">
<div class="flex flex-col">
<span class="text-sm font-medium">Ethics Approval Required</span>
<span class="text-[10px] text-slate-500">Must be verified before project start</span>
</div>
<div class="w-10 h-6 bg-primary rounded-full relative cursor-pointer">
<div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
</div>
</div>
<div class="flex items-center justify-between p-3 bg-background-light dark:bg-slate-800/50 rounded-lg">
<div class="flex flex-col">
<span class="text-sm font-medium">Monthly Progress Reports</span>
<span class="text-[10px] text-slate-500">Mandatory for student funding</span>
</div>
<div class="w-10 h-6 bg-slate-300 dark:bg-slate-700 rounded-full relative cursor-pointer">
<div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
</div>
</div>
</div>
<!-- Requirements Inputs -->
<div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800">
<h4 class="text-xs font-bold uppercase tracking-widest text-slate-400">Academic Thresholds</h4>
<div class="space-y-2">
<label class="text-xs font-medium text-slate-600 dark:text-slate-400">Minimum Credits for Eligibility</label>
<input class="w-full bg-background-light dark:bg-slate-800 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" type="number" value="90"/>
</div>
<div class="space-y-2">
<label class="text-xs font-medium text-slate-600 dark:text-slate-400">Supervisor Max Load (Students)</label>
<input class="w-full bg-background-light dark:bg-slate-800 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" type="number" value="5"/>
</div>
</div>
<!-- Action Buttons -->
<div class="pt-6 grid grid-cols-2 gap-3">
<button class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                Reset Default
                            </button>
<button class="px-4 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:shadow-lg hover:shadow-primary/30 transition-all">
                                Save Changes
                            </button>
</div>
</div>
<div class="mt-10 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-xl flex gap-3">
<span class="material-icons text-primary">info</span>
<p class="text-[11px] text-blue-800 dark:text-blue-300">
                            Changes made to Global Requirements will take effect from the next academic semester starting <strong>September 2024</strong>.
                        </p>
</div>
</div>
</div>
</div>
<!-- System Stats Footer -->
<section class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
<div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
<span class="material-icons text-xl">dataset</span>
</div>
<div>
<div class="text-2xl font-bold">12</div>
<div class="text-[10px] uppercase font-bold text-slate-400">Total Departments</div>
</div>
</div>
<div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
<div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
<span class="material-icons text-xl">check_circle</span>
</div>
<div>
<div class="text-2xl font-bold">342</div>
<div class="text-[10px] uppercase font-bold text-slate-400">Live Projects</div>
</div>
</div>
<div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
<div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
<span class="material-icons text-xl">warning</span>
</div>
<div>
<div class="text-2xl font-bold">08</div>
<div class="text-[10px] uppercase font-bold text-slate-400">Pending Actions</div>
</div>
</div>
<div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
<div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
<span class="material-icons text-xl">history_edu</span>
</div>
<div>
<div class="text-2xl font-bold">89%</div>
<div class="text-[10px] uppercase font-bold text-slate-400">Completion Rate</div>
</div>
</div>
</section>
</main>
</body></html>
