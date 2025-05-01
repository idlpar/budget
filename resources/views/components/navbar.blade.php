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
                        <div class="relative" x-data="{ accountsOpen: false }" @click.away="accountsOpen = false">
                            <button @click="accountsOpen = !accountsOpen" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('accounts.*') ? 'bg-indigo-900' : '' }}">
                                Accounts Head
                                <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="budgetsOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                            <a href="{{ route('budgets.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">List Budgets</a>
                            <a href="{{ route('budgets.upload-form') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Upload Budget</a>
                            <a href="{{ route('budgets.import.form') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Import Budgets</a>
                        </div>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('expenses.*') ? 'bg-indigo-900' : '' }}">Expenses</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('imports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                    @endif
                    <a href="{{ route('reports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>
                @endauth
                <div class="relative" x-data="{ userOpen: false }" @click.away="userOpen = false">
                    @auth
                        <button @click="userOpen = !userOpen" class="flex items-center space-x-2 text-white hover:text-emerald-300 focus:outline-none transition-all duration-200" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <div class="h-8 w-8 rounded-full border-2 border-emerald-300 overflow-hidden" id="avatar-container">
                                <img
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}"
                                    alt="Avatar"
                                    class="h-full w-full object-cover"
                                    onerror="this.style.display='none'; document.getElementById('avatar-fallback').style.display='block';"
                                >
                                <div id="avatar-fallback" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 494 511.5"><path fill="#D9E9F0" fill-rule="nonzero" d="M246.999 0c139.846 0 247 118.492 247 255.749 0 137.286-107.146 255.751-247 255.751C107.136 511.5 0 393.041 0 255.749 0 119.253 106.347 0 246.999 0z"/><path fill="#194794" fill-rule="nonzero" d="M443.262 410.755c-44.365 60.337-114.245 100.375-195.179 100.731a485.973 485.973 0 01-10.864-.202c-77.469-3.082-144.112-42.601-186.864-101.048 14.588-29.09 45.279-46.423 76.205-50.56 31.076-4.154 56.937-8.371 67.876-45.937 2.831 2.48 5.803 4.983 8.835 7.677 28.308 25.167 60.205 26.261 87.478-.041 2.24-2.168 4.433-4.208 6.53-6.193 13.959 31.067 46.917 36.552 74.708 41.926 28.807 5.565 57.181 26.462 71.275 53.647z"/><path fill="#D2A75F" fill-rule="nonzero" d="M297.279 315.189c7.303 16.248 19.804 25.504 34.034 31.396-48.137 35.317-114.594 33.276-164.102 3.093 14.996-8.076 22.505-19.772 27.209-35.947 2.83 2.479 5.812 4.982 8.849 7.685 28.31 25.169 60.208 26.261 87.481-.04 2.24-2.168 4.432-4.209 6.529-6.187z"/><path fill="#DBB26F" fill-rule="nonzero" d="M249.676 372.686c-28.788.127-57.743-7.941-82.465-23.008 14.94-8.044 22.641-19.923 27.217-35.947 2.838 2.479 5.804 4.982 8.841 7.685 14.869 13.218 30.742 19.795 46.407 19.253v32.017z"/><path fill="#E9BE79" d="M149.695 229.121c3.736-10.692 12.422-7.254 24.8-2.737-4.944-22.418.89-39.929 18.442-52.069 37.446-25.908 54.37-3.733 94.957-36.414 23.316 11.743 44.177 31.595 33.547 93.617 11.252-8.527 27.477-7.732 22.374 11.156l-6.972 19.747c-1.667 4.726-2.782 6.44-8.754 6.119-2.64-.14-5.293-1.156-7.94-2.906 2.445 29.138-11.701 38.645-29.404 55.732-27.267 26.312-59.166 25.226-87.468.048-16.578-14.745-31.301-23.7-32.035-54.014-4.3 1.317-8.362 1.557-11.912-.461-7.072-4.025-9.648-15.739-10.035-23.243-.154-3.015-.026-11.503.4-14.575z"/><path fill="#F2CD8C" d="M149.696 229.121c3.739-10.693 12.419-7.251 24.799-2.737l-.111-.534.111.061c6.452-67.735 40.082-57.55 75.178-66.2v180.957c-15.661.548-31.528-6.024-46.398-19.254-16.577-14.745-31.301-23.697-32.031-54.012-4.297 1.314-8.364 1.555-11.911-.463-10.301-5.863-11.132-27.064-9.637-37.818z"/><path fill="#462917" d="M128.296 133.328c54.61-67.481 117.552-104.183 164.815-44.153 57.919 3.041 78.011 97.546 29.434 134.416 3.891-51.331-11.304-74.352-34.8-85.921-44.719 48.763-104.421-4.43-113.25 88.238l-21.432-11.162c-2.128-26.578 4.097-72.688-24.767-81.418z"/></svg>
                                </div>
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="userOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 transform transition-all duration-300 ease-out" x-cloak>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Profile</a>
                            <a href="{{ route('users.change-password') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Change Password</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('users.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Create New User</a>
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Users</a>
                                <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Accounts Head</a>
                            @endif
                            <a href="{{ route('budgets.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Budgets</a>
                            <a href="{{ route('expenses.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Expenses</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('imports.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Imports</a>
                            @endif
                            <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg">Reports</a>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center lg:hidden">
                <button type="button" class="p-2 rounded-md text-white hover:text-emerald-300 hover:bg-indigo-900 focus:outline-none" id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-indigo-700 dark:bg-indigo-800">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('dashboard') ? 'bg-indigo-900' : '' }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Profile</a>
                <a href="{{ route('users.change-password') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Change Password</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('users.create') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Create New User</a>
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('users.*') ? 'bg-indigo-900' : '' }}">Users</a>
                    <a href="{{ route('accounts.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('accounts.*') ? 'bg-indigo-900' : '' }}">Accounts Head</a>
                    <a href="{{ route('accounts.create') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('accounts.create') ? 'bg-indigo-900' : '' }}">Create Account</a>
                    <a href="{{ route('accounts.import.form') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('accounts.import.form') ? 'bg-indigo-900' : '' }}">Import Accounts</a>
                    <a href="{{ route('imports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                @endif
                <a href="{{ route('budgets.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('budgets.*') ? 'bg-indigo-900' : '' }}">Budgets</a>
                <a href="{{ route('budgets.upload-form') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('budgets.upload-form') ? 'bg-indigo-900' : '' }}">Upload Budget</a>
                <a href="{{ route('budgets.import.form') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('budgets.import.form') ? 'bg-indigo-900' : '' }}">Import Budgets</a>
                <a href="{{ route('expenses.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('expenses.*') ? 'bg-indigo-900' : '' }}">Expenses</a>
                <a href="{{ route('reports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>
                <a href="{{ route('logout') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Login</a>
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
