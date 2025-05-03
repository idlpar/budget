<aside class="w-64 bg-indigo-50 dark:bg-indigo-950 text-slate-700 dark:text-slate-200 shadow-lg transition-all duration-300 hidden lg:block">
    <div class="p-4">
        <h2 class="text-lg font-semibold text-indigo-800 dark:text-indigo-300 mb-4">Navigation</h2>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('dashboard') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('users.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Users</span>
                </a>
                <a href="{{ route('accounts.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('accounts.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Accounts</span>
                </a>
            @endif
            <a href="{{ route('budgets.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('budgets.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Budgets</span>
            </a>
            <a href="{{ route('expenses.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('expenses.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Expenses</span>
            </a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('imports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('imports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Imports</span>
                </a>
                <a href="{{ route('organogram.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('organogram.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Organogram</span>
                </a>
            @endif
            <a href="{{ route('transactions.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('transactions.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Transactions</span>
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('reports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Reports</span>
            </a>
        </nav>
    </div>
</aside>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            profileOpen: false,
            usersOpen: false,
            accountsOpen: false,
            budgetsOpen: false,
            expensesOpen: false,
        }));
    });

    // Toggle sidebar
    document.getElementById('close-sidebar')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.add('-translate-x-full');
    });

    // Open sidebar on mobile
    document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
    });
</script>
