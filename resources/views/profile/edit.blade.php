<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Supervisor Academic Profile | Project Management System</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
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
    <style>
        body {
            font-family: 'Lexend', sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <!-- Navigation Bar -->
    <nav
        class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="bg-primary p-1.5 rounded-lg">
                <span class="material-icons-outlined text-white text-2xl">school</span>
            </div>
            <span class="font-bold text-xl tracking-tight text-primary">EduTrack</span>
        </div>
        <div class="flex items-center gap-6">
            <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Dashboard</a>
            <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Projects</a>
            <a class="text-sm font-medium hover:text-primary transition-colors text-primary" href="#">Faculty</a>
            <div class="h-8 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>
            <button
                class="flex items-center gap-2 bg-primary/10 hover:bg-primary/20 text-primary px-4 py-2 rounded-lg transition-all">
                <span class="material-icons-outlined text-sm">edit</span>
                <span class="text-sm font-semibold">Edit Profile</span>
            </button>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto p-6 lg:p-10">
        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Left Column: Identity & Capacity (4 cols) -->
            <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">
                <!-- Profile Header -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl p-8 shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <img alt="Profile Picture"
                            class="w-32 h-32 rounded-full object-cover border-4 border-primary/20 p-1"
                            data-alt="Professional portrait of a male professor"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC7XfRue9u6S8FxH3QShPWkEaNFgqbe79yR14KTaQFJZj7Pe61wk0rTWvAbtMkZzBsnzAfkIjvvlbPWAL0Zy2phstyTYT721au0EfWnu6TVZm3AqXpnKNcgPcGOufUMxw3ZxIbw0nmUT9JmkSrekeHCrrRweXQ-yIB5vf0pCP_rs7x_EmdWq9lkzDDnJRIwCGxIgANpZHstlk3ezvtJ46aZvYp-xTHKlXGd45DVAekGEIGqgj6F7qldbqtas8cMRloKg_WTwzQyK2I" />
                        <div
                            class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white dark:border-slate-800 rounded-full">
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold mb-1">Dr. Alistair Thorne</h1>
                    <p class="text-primary font-medium mb-4">Senior Lecturer &amp; Researcher</p>
                    <div class="flex flex-col gap-2 w-full pt-4 border-t border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span class="material-icons-outlined text-sm">business</span>
                            <span>Dept. of Artificial Intelligence</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span class="material-icons-outlined text-sm">mail</span>
                            <span>a.thorne@university.edu</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span class="material-icons-outlined text-sm">location_on</span>
                            <span>Science Block, Room 402</span>
                        </div>
                    </div>
                </div>
                <!-- Supervision Capacity Widget -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Supervision Capacity</h3>
                        <span
                            class="px-2 py-1 rounded bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-xs font-bold uppercase tracking-wider">Almost
                            Full</span>
                    </div>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span
                                    class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-primary bg-primary/10">
                                    Current Load
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-primary">
                                    4 / 5 Slots
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-3 mb-4 text-xs flex rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary rounded-full transition-all duration-500"
                                style="width:80%"></div>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed italic">
                            * Accepting 1 more student for the Spring 2024 cohort. Preference for projects in Neural
                            Networks.
                        </p>
                    </div>
                </div>
                <!-- Consultation Hours -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Consultation</h3>
                        <button class="text-primary hover:underline text-xs font-medium">Update</button>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 dark:bg-slate-900/50">
                            <span class="text-sm font-medium">Monday</span>
                            <span class="text-sm text-slate-500">10:00 - 12:00</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-lg bg-slate-50 dark:bg-slate-900/50 border-l-4 border-primary">
                            <span class="text-sm font-medium">Wednesday</span>
                            <span
                                class="text-sm text-primary font-semibold underline underline-offset-4 cursor-pointer">Open
                                Now</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 dark:bg-slate-900/50">
                            <span class="text-sm font-medium">Thursday</span>
                            <span class="text-sm text-slate-500">14:00 - 16:00</span>
                        </div>
                    </div>
                    <button
                        class="w-full mt-4 py-2 bg-primary text-white rounded-lg font-semibold text-sm hover:brightness-110 transition-all flex items-center justify-center gap-2">
                        <span class="material-icons-outlined text-sm">event</span>
                        Book a Meeting
                    </button>
                </div>
            </div>
            <!-- Right Column: Bio, Research, Supervisees (8 cols) -->
            <div class="col-span-12 lg:col-span-8 flex flex-col gap-6">
                <!-- About & Specializations -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <span class="material-icons-outlined text-primary">person</span>
                        Supervisor Bio
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-8">
                        Dr. Alistair Thorne has over 15 years of experience in the field of Computer Science,
                        specializing in Deep Learning and Human-Centered AI. He has published over 40 peer-reviewed
                        articles and has successfully supervised 25+ undergraduate theses to completion. His current
                        research focuses on the intersection of ethical AI and adaptive educational systems.
                    </p>
                    <h3 class="font-bold text-sm uppercase tracking-widest text-slate-400 mb-4">Research Specializations
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="px-4 py-2 bg-primary/5 border border-primary/20 text-primary rounded-full text-sm font-medium">Natural
                            Language Processing</span>
                        <span
                            class="px-4 py-2 bg-primary/5 border border-primary/20 text-primary rounded-full text-sm font-medium">Adaptive
                            Learning</span>
                        <span
                            class="px-4 py-2 bg-primary/5 border border-primary/20 text-primary rounded-full text-sm font-medium">Neural
                            Networks</span>
                        <span
                            class="px-4 py-2 bg-primary/5 border border-primary/20 text-primary rounded-full text-sm font-medium">Ethics
                            in AI</span>
                        <span
                            class="px-4 py-2 bg-primary/5 border border-primary/20 text-primary rounded-full text-sm font-medium">Big
                            Data Analytics</span>
                    </div>
                </div>
                <!-- Current Supervisees -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-icons-outlined text-primary">groups</span>
                            Current Supervisees
                        </h2>
                        <span class="text-sm font-medium text-slate-500">4 Active Projects</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/50">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Student</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Project Title</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Status
                                    </th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <!-- Student 1 -->
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                                EK</div>
                                            <span class="font-medium text-sm">Elena Kostic</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1 max-w-xs">
                                            Real-time Sign Language Translation using CNNs</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">Drafting</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            class="text-primary font-semibold text-xs hover:bg-primary/5 px-3 py-1.5 rounded-lg border border-primary/20 transition-all">Workspace</button>
                                    </td>
                                </tr>
                                <!-- Student 2 -->
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                                JD</div>
                                            <span class="font-medium text-sm">Julian De Luca</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1 max-w-xs">
                                            Bias Mitigation in Automated Hiring Systems</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">Research</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            class="text-primary font-semibold text-xs hover:bg-primary/5 px-3 py-1.5 rounded-lg border border-primary/20 transition-all">Workspace</button>
                                    </td>
                                </tr>
                                <!-- Student 3 -->
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                                ST</div>
                                            <span class="font-medium text-sm">Sarah Tan</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1 max-w-xs">
                                            Sentiment Analysis for Educational Feedback</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">Implementation</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            class="text-primary font-semibold text-xs hover:bg-primary/5 px-3 py-1.5 rounded-lg border border-primary/20 transition-all">Workspace</button>
                                    </td>
                                </tr>
                                <!-- Student 4 -->
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                                MR</div>
                                            <span class="font-medium text-sm">Marcus Reed</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1 max-w-xs">
                                            Graph Neural Networks for Drug Discovery</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">Literature
                                            Review</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            class="text-primary font-semibold text-xs hover:bg-primary/5 px-3 py-1.5 rounded-lg border border-primary/20 transition-all">Workspace</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 text-center">
                        <button class="text-slate-500 hover:text-primary text-sm font-medium transition-colors">View
                            All Supervision History</button>
                    </div>
                </div>
                <!-- Recent Activity/News -->
                <div class="grid grid-cols-2 gap-6">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
                        <h4 class="font-bold mb-4 flex items-center gap-2">
                            <span class="material-icons-outlined text-sm text-primary">description</span>
                            Latest Publication
                        </h4>
                        <p class="text-sm font-medium leading-snug mb-2">"Ethical Considerations in Large Language
                            Models for Undergraduate Education"</p>
                        <p class="text-xs text-slate-400 italic">Published in AI &amp; Society Journal, Nov 2023</p>
                    </div>
                    <div
                        class="bg-primary rounded-xl p-6 shadow-sm flex flex-col justify-center items-center text-center text-white">
                        <span class="material-icons-outlined text-4xl mb-2 opacity-80">campaign</span>
                        <h4 class="font-bold text-lg leading-tight">Apply for Supervision</h4>
                        <p class="text-xs text-white/80 mt-2 mb-4">Submission deadline for Spring Term: Dec 15th</p>
                        <button
                            class="bg-white text-primary px-6 py-2 rounded-lg font-bold text-sm shadow-lg hover:scale-105 transition-all">Learn
                            More</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer
        class="max-w-7xl mx-auto px-6 py-10 mt-10 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center text-slate-400 text-sm">
        <div class="flex items-center gap-2 mb-4 md:mb-0 opacity-60 grayscale">
            <span class="material-icons-outlined text-xl">school</span>
            <span class="font-bold text-lg tracking-tight">EduTrack</span>
        </div>
        <div class="flex gap-8">
            <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
            <a class="hover:text-primary transition-colors" href="#">Support Center</a>
        </div>
        <div class="mt-4 md:mt-0">
            © 2024 University Academic Portal. All rights reserved.
        </div>
    </footer>
</body>

</html>
