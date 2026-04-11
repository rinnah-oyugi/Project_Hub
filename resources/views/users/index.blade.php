<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin: User Management | ProjectSync</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
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
                        "display": ["Inter"]
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
<style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen font-display">
<!-- Sidebar Navigation (Briefly represented for context) -->
<aside class="fixed left-0 top-0 h-full w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 hidden lg:block">
<div class="p-6 flex items-center gap-3">
<div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
<span class="material-icons">account_tree</span>
</div>
<span class="text-xl font-bold tracking-tight text-slate-800 dark:text-white">ProjectSync</span>
</div>
<nav class="mt-6 px-4 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors" href="/dashboard">
<span class="material-icons text-xl">dashboard</span> Dashboard
            </a>
<a class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-lg font-medium" href="#">
<span class="material-icons text-xl">people</span> User Management
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
<span class="material-icons text-xl">folder</span> Projects
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
<span class="material-icons text-xl">assignment</span> Assignments
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
<span class="material-icons text-xl">settings</span> Settings
            </a>
</nav>
</aside>
<!-- Main Content Area -->
<main class="lg:ml-64 p-8">
<!-- Header -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
<div>
<h1 class="text-2xl font-bold text-slate-900 dark:text-white">User Management</h1>
<p class="text-slate-500 dark:text-slate-400 text-sm">Manage student, supervisor, and admin credentials across all departments.</p>
</div>
<button class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm shadow-primary/20 transition-all">
<span class="material-icons text-sm">add</span>
                Add New User
            </button>
</header>
<!-- Stats Overview (Subtle Cards) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
<p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Total Users</p>
<p class="text-2xl font-bold text-slate-900 dark:text-white">1,284</p>
</div>
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
<p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Active Students</p>
<p class="text-2xl font-bold text-slate-900 dark:text-white">1,050</p>
</div>
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
<p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Supervisors</p>
<p class="text-2xl font-bold text-slate-900 dark:text-white">214</p>
</div>
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
<p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Pending Requests</p>
<p class="text-2xl font-bold text-primary">12</p>
</div>
</div>
<!-- Filters & Search Bar -->
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 mb-6 shadow-sm">
<div class="flex flex-col xl:flex-row items-center gap-4">
<div class="relative w-full xl:max-w-md">
<span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
<input class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm transition-all" placeholder="Search by name, email or ID..." type="text"/>
</div>
<div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
<select class="bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary py-2 px-3 text-slate-600 dark:text-slate-300">
<option value="">All Roles</option>
<option value="student">Student</option>
<option value="supervisor">Supervisor</option>
<option value="admin">Admin</option>
</select>
<select class="bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary py-2 px-3 text-slate-600 dark:text-slate-300">
<option value="">All Departments</option>
<option value="cs">Computer Science</option>
<option value="ee">Electrical Engineering</option>
<option value="me">Mechanical Engineering</option>
<option value="ba">Business Admin</option>
</select>
<select class="bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary py-2 px-3 text-slate-600 dark:text-slate-300">
<option value="">All Status</option>
<option value="active">Active</option>
<option value="inactive">Inactive</option>
<option value="pending">Pending</option>
</select>
<button class="ml-auto xl:ml-0 inline-flex items-center gap-2 text-slate-500 hover:text-primary transition-colors text-sm font-medium">
<span class="material-icons text-sm">filter_list</span>
                        Clear Filters
                    </button>
</div>
</div>
</div>
<!-- Data Table Container -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
<div class="overflow-x-auto custom-scrollbar">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</th>
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">User Details</th>
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Role</th>
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Department</th>
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
<th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 dark:divide-slate-800">
<!-- User Row 1 -->
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
<td class="px-6 py-4">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
<span class="text-primary font-bold text-sm">AM</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Alex Morgan</p>
<p class="text-xs text-slate-500">alex.morgan@university.edu</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    Undergraduate Student
                                </span>
</td>
<td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                Computer Science
                            </td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                    Active
                                </span>
</td>
<td class="px-6 py-4 text-right">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400 transition-colors">
<span class="material-icons">more_vert</span>
</button>
</td>
</tr>
<!-- User Row 2 -->
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
<td class="px-6 py-4">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
<span class="text-purple-600 dark:text-purple-300 font-bold text-sm">SH</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Dr. Sarah Higgins</p>
<p class="text-xs text-slate-500">s.higgins@faculty.edu</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                    Faculty Supervisor
                                </span>
</td>
<td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                Mechanical Engineering
                            </td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                    Active
                                </span>
</td>
<td class="px-6 py-4 text-right">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400 transition-colors">
<span class="material-icons">more_vert</span>
</button>
</td>
</tr>
<!-- User Row 3 -->
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
<td class="px-6 py-4">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
<span class="text-amber-600 dark:text-amber-300 font-bold text-sm">JD</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">James Donovan</p>
<p class="text-xs text-slate-500">j.donovan@it.edu</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                                    System Admin
                                </span>
</td>
<td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                Administration
                            </td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                    Active
                                </span>
</td>
<td class="px-6 py-4 text-right">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400 transition-colors">
<span class="material-icons">more_vert</span>
</button>
</td>
</tr>
<!-- User Row 4 (Pending) -->
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
<td class="px-6 py-4">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
<span class="text-slate-600 dark:text-slate-400 font-bold text-sm">LC</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Lisa Chen</p>
<p class="text-xs text-slate-500">l.chen@university.edu</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    Undergraduate Student
                                </span>
</td>
<td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                Data Science
                            </td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Pending
                                </span>
</td>
<td class="px-6 py-4 text-right">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400 transition-colors">
<span class="material-icons">more_vert</span>
</button>
</td>
</tr>
<!-- User Row 5 (Inactive) -->
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors opacity-75">
<td class="px-6 py-4">
<input class="rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary" type="checkbox"/>
</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
<span class="text-slate-400 font-bold text-sm">RK</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Robert Kim</p>
<p class="text-xs text-slate-500 text-slate-400">r.kim@university.edu</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    Undergraduate Student
                                </span>
</td>
<td class="px-6 py-4 text-sm text-slate-400">
                                Computer Science
                            </td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
<span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                    Inactive
                                </span>
</td>
<td class="px-6 py-4 text-right">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400 transition-colors">
<span class="material-icons">more_vert</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="px-6 py-4 flex items-center justify-between border-t border-slate-200 dark:border-slate-800">
<p class="text-sm text-slate-500 dark:text-slate-400">
                    Showing <span class="font-semibold text-slate-900 dark:text-white">1</span> to <span class="font-semibold text-slate-900 dark:text-white">10</span> of <span class="font-semibold text-slate-900 dark:text-white">1,284</span> users
                </p>
<div class="flex items-center gap-2">
<button class="p-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors disabled:opacity-50" disabled="">
<span class="material-icons text-sm">chevron_left</span>
</button>
<button class="w-8 h-8 rounded-lg bg-primary text-white text-sm font-semibold">1</button>
<button class="w-8 h-8 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">2</button>
<button class="w-8 h-8 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">3</button>
<span class="text-slate-400 px-1 text-xs">...</span>
<button class="w-8 h-8 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">129</button>
<button class="p-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
<span class="material-icons text-sm">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Bulk Action Toast (Floating/Hidden by default usually) -->
<div class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-6 animate-slide-up lg:ml-32">
<span class="text-sm font-medium">3 users selected</span>
<div class="h-4 w-px bg-slate-700"></div>
<div class="flex items-center gap-4">
<button class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
<span class="material-icons text-lg text-primary">edit</span> Edit Role
                </button>
<button class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
<span class="material-icons text-lg text-amber-500">lock_reset</span> Reset Password
                </button>
<button class="flex items-center gap-2 text-sm text-red-400 hover:text-red-300 transition-colors">
<span class="material-icons text-lg">block</span> Deactivate
                </button>
</div>
<button class="ml-4 p-1 hover:bg-slate-800 rounded-full transition-colors text-slate-500">
<span class="material-icons text-sm">close</span>
</button>
</div>
</main>
<!-- Modal Overlay Background Mockup (Not functional but shown for design depth) -->
<!-- <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="text-lg font-bold">Add New User</h3>
                <button class="text-slate-400 hover:text-slate-600"><span class="material-icons">close</span></button>
            </div>
            <div class="p-6">
                ... modal content ...
            </div>
        </div>
    </div> -->
</body></html>
