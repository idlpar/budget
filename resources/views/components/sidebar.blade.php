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
        <a href="{{ route('home') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('home') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('dashboard') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>
        @auth
            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md w-full text-left {{ Route::is('profile.*', 'users.change-password') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile</span>
                    <svg class="h-5 w-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="profileOpen" class="ml-6 mt-1 space-y-1" x-cloak>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Edit Profile</a>
                    <a href="{{ route('users.change-password') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Change Password</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Register User</a>
                    @endif
                </div>
            </div>
            @if (auth()->user()->isAdmin())
                <!-- Users Dropdown -->
                <div class="relative" x-data="{ usersOpen: false }" @click.away="usersOpen = false">
                    <button @click="usersOpen = !usersOpen" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md w-full text-left {{ Route::is('users.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Users</span>
                        <svg class="h-5 w-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="usersOpen" class="ml-6 mt-1 space-y-1" x-cloak>
                        <a href="{{ route('users.index') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">List Users</a>
                        <a href="{{ route('users.create') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Create New User</a>
                    </div>
                </div>
                <!-- Accounts Dropdown -->
                <div class="relative" x-data="{ accountsOpen: false }" @click.away="accountsOpen = false">
                    <button @click="accountsOpen = !accountsOpen" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md w-full text-left {{ Route::is('accounts.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <span>Accounts Head</span>
                        <svg class="h-5 w-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="accountsOpen" class="ml-6 mt-1 space-y-1" x-cloak>
                        <a href="{{ route('accounts.index') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">List Accounts</a>
                        <a href="{{ route('accounts.create') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Create Account</a>
                        <a href="{{ route('accounts.import.form') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Import Accounts</a>
                    </div>
                </div>
            @endif
            <!-- Budgets Dropdown -->
            <div class="relative" x-data="{ budgetsOpen: false }" @click.away="budgetsOpen = false">
                <button @click="budgetsOpen = !budgetsOpen" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md w-full text-left {{ Route::is('budgets.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Budgets</span>
                    <svg class="h-5 w-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="budgetsOpen" class="ml-6 mt-1 space-y-1" x-cloak>
                    <a href="{{ route('budgets.index') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">List Budgets</a>
                    <a href="{{ route('budgets.upload-form') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Upload Budget</a>
                    <a href="{{ route('budgets.import.form') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Import Budgets</a>
                </div>
            </div>
            <!-- Expenses Dropdown -->
            <div class="relative" x-data="{ expensesOpen: false }" @click.away="expensesOpen = false">
                <button @click="expensesOpen = !expensesOpen" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md w-full text-left {{ Route::is('expenses.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Expenses</span>
                    <svg class="h-5 w-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="expensesOpen" class="ml-6 mt-1 space-y-1" x-cloak>
                    <a href="{{ route('expenses.index') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">List Expenses</a>
                    <a href="{{ route('expenses.create') }}" class="block px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md">Create Expense</a>
                </div>
            </div>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('imports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('imports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6M15.9 6L13 8m0 0l-3 3m3-3v6" />
                    </svg>
                    <span>Imports</span>
                </a>
            @endif
            <a href="{{ route('reports.index') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('reports.*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Reports</span>
            </a>
            <a href="{{ route('logout') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('login') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Login</span>
            </a>
            <a href="{{ route('password.request') }}" class="flex items-center space-x-2 px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-md {{ Route::is('password.request') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-300' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                <span>Forgot Password</span>
            </a>
        @endauth
    </nav>
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
