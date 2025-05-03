<nav class="bg-gradient-to-r from-indigo-600 to-indigo-800 dark:from-indigo-900 dark:to-indigo-700 shadow-lg">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white text-xl font-bold hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('logo.png') }}" class="h-12 w-auto" alt="Logo" loading="lazy">
                    <span>Budget Control</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('dashboard') ? 'bg-indigo-900' : '' }}">Dashboard</a>

                    @if (auth()->user()->isAdmin())
                        <!-- Users Dropdown -->
                        <div class="relative" x-data="{ usersOpen: false }" @click.away="usersOpen = false">
                            <button @click="usersOpen = !usersOpen" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('users.*') ? 'bg-indigo-900' : '' }}">
                                Users
                                <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="usersOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">List Users</a>
                                <a href="{{ route('users.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Create New User</a>
                            </div>
                        </div>
                        <!-- Accounts Dropdown -->
                        <div class="relative" x-data="{ accountsOpen: false }" @click.away="accountsOpen = false">
                            <button @click="accountsOpen = !accountsOpen" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('accounts.*') ? 'bg-indigo-900' : '' }}">
                                Accounts Head
                                <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>
                            <div x-show="accountsOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                                <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">List Accounts</a>
                                <a href="{{ route('accounts.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Create Account</a>
                                <a href="{{ route('accounts.import.form') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Import Accounts</a>
                            </div>
                        </div>
                    @endif

                    <!-- Budgets Dropdown -->
                    <div class="relative" x-data="{ budgetsOpen: false }" @click.away="budgetsOpen = false">
                        <button @click="budgetsOpen = !budgetsOpen" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('budgets.*') ? 'bg-indigo-900' : '' }}">
                            Budgets
                            <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        <div x-show="budgetsOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                            <a href="{{ route('budgets.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">List Budgets</a>
                            <a href="{{ route('budgets.upload-form') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Upload Budget</a>
                            <a href="{{ route('budgets.import.form') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Import Budgets</a>
                        </div>
                    </div>

                    <!-- Expenses Dropdown -->
                    <div class="relative" x-data="{ expensesOpen: false }" @click.away="expensesOpen = false">
                        <button @click="expensesOpen = !expensesOpen" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('expenses.*') ? 'bg-indigo-900' : '' }}">
                            Expenses
                            <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </button>
                        <div x-show="expensesOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                            <a href="{{ route('expenses.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">List Expenses</a>
                            <a href="{{ route('expenses.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Create Expense</a>
                        </div>
                    </div>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('imports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                        <a href="{{ route('organogram.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('organogram.*') ? 'bg-indigo-900' : '' }}">Organogram</a>
                    @endif

                    <a href="{{ route('transactions.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('transactions.*') ? 'bg-indigo-900' : '' }}">Transactions</a>

                    <a href="{{ route('reports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ userOpen: false }" @click.away="userOpen = false">
                        <button @click="userOpen = !userOpen" class="flex items-center space-x-2 text-white hover:text-emerald-300 focus:outline-none transition-all duration-200" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <div class="h-8 w-8 rounded-full border-2 border-emerald-300 overflow-hidden" id="avatar-container">
                                <img
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}"
                                    alt="Avatar"
                                    class="h-full w-full object-cover"
                                    onerror="this.style.display='none'; document.getElementById('avatar-fallback').style.display='block';"
                                >
                                <div id="avatar-fallback" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 494 511.5"><path fill="#D9E9F0" fill-rule="nonzero" d="M246.999 0c139.846 0 247 118.492 247 255.749 0 137.286-107.146 255.751-247 255.751C107.136 511.5 0 393.041 0 255.749 0 119.253 106.347 0 246.999 0z"/><path fill="#194794" fill-rule="nonzero" d="M443.262 410.755c-44.365 60.337-114.245 100.375-195.179 100.731a485.973 485.973 0 01-10.864-.202c-77.469-3.082-144.112-42.601-186.864-101.048 14.588-29.09 45.279-46.423 76.205-50.56 31.076-4.154 56.937-8.371 67.876-45.937 2.831 2.48 5.803 4.983 8.835 7.677 28.308 25.167 60.205 26.261 87.478-.041 2.24-2.168 4.433-4.208 6.53-6.193 13.959 31.067 46.917 36.552 74.708 41.926 28.807 5.565 57.181 26.462 71.275 53.647z"/><path fill="#D2A75F" fill-rule="nonzero" d="M297.279 315.189c7.303 16.248 19.804 25.504 34.034 31.396-48.137 35.317-114.594 33.276-164.102 3.093 14.996-8.076 22.505-19.772 27.209-35.947 2.83 2.479 5.812 4.982 8.849 7.685 28.31 25.169 60.208 26.261 87.481-.04 2.24-2.168 4.432-4.209 6.529-6.187z"/><path fill="#DBB26F" fill-rule="nonzero" d="M249.676 372.686c-28.788.127-57.743-7.941-82.465-23.008 14.94-8.044 22.641-19.923 27.217-35.947 2.838 2.479 5.804 4.982 8.841 7.685 14.869 13.218 30.742 19.795 46.407 19.253v32.017z"/><path fill="#E9BE79" d="M149.695 229.121c3.736-10.692 12.422-7.254 24.8-2.737-4.944-22.418.89-39.929 18.442-52.069 37.446-25.908 54.37-3.733 94.957-36.414 23.316 11.743 44.177 31.865 54.252 59.149 8.326 22.531 5.263 44.639-9.458 62.226-7.604 9.072-18.378 16.222-31.032 20.855-12.378 4.533-24.666 5.198-37.389 5.198-20.574 0-40.467-5.198-58.342-14.657-17.984-9.54-34.027-23.08-41.632-41.551z"/></svg>
                                </div>
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="userOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Profile</a>
                            <a href="{{ route('users.change-password') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Change Password</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Users</a>
                                <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Accounts</a>
                            @endif
                            <a href="{{ route('budgets.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Budgets</a>
                            <a href="{{ route('expenses.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Expenses</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('imports.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Imports</a>
                                <a href="{{ route('organogram.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Organogram</a>
                            @endif
                            <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Transactions</a>
                            <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Reports</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-emerald-300 focus:outline-none" aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" x-cloak />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" class="lg:hidden" x-cloak>
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('dashboard') ? 'bg-indigo-900' : '' }}">Dashboard</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('users.*') ? 'bg-indigo-900' : '' }}">Users</a>
                    <a href="{{ route('accounts.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('accounts.*') ? 'bg-indigo-900' : '' }}">Accounts</a>
                @endif
                <a href="{{ route('budgets.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('budgets.*') ? 'bg-indigo-900' : '' }}">Budgets</a>
                <a href="{{ route('expenses.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('expenses.*') ? 'bg-indigo-900' : '' }}">Expenses</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('imports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                    <a href="{{ route('organogram.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('organogram.*') ? 'bg-indigo-900' : '' }}">Organogram</a>
                @endif
                <a href="{{ route('transactions.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('transactions.*') ? 'bg-indigo-900' : '' }}">Transactions</a>
                <a href="{{ route('reports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('profile.*') ? 'bg-indigo-900' : '' }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Register</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            usersOpen: false,
            accountsOpen: false,
            budgetsOpen: false, // Added for budgets dropdown
            userOpen: false,
            mobileOpen: false,
        }));
    });

    // Toggle mobile menu
    document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
