<aside class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-slate-800 shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:static lg:w-64 z-50" id="sidebar">
    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-indigo-600 dark:text-indigo-300 font-bold text-lg">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Budget Control</span>
        </a>
        <button class="lg:hidden text-slate-600 dark:text-slate-300 hover:text-indigo-600 focus:outline-none" id="close-sidebar">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('dashboard') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('users.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span>Users</span>
        </a>
        <a href="{{ route('budgets.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('budgets.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Budgets</span>
        </a>
        <a href="{{ route('approvals.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('approvals.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Approvals</span>
        </a>
        <a href="{{ route('imports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('imports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6M15.9 6L13 8m0 0l-3 3m3-3v6" /></svg>
            <span>Imports</span>
        </a>
        <a href="{{ route('reports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('reports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span>Reports</span>
        </a>
    </nav>
</aside>

<script>
    // Toggle sidebar
    document.getElementById('close-sidebar')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
    });

    // Open sidebar on mobile
    document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
    });
</script>
