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
                    <a href="{{ route('users.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('users.*') ? 'bg-indigo-900' : '' }}">Users</a>
                    <a href="{{ route('budgets.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('budgets.*') ? 'bg-indigo-900' : '' }}">Budgets</a>
                    <a href="{{ route('approvals.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('approvals.*') ? 'bg-indigo-900' : '' }}">Approvals</a>
                    <a href="{{ route('imports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                    <a href="{{ route('reports.index') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>
                @endauth
                <div class="relative">
                    @auth
                        <button class="flex items-center space-x-2 text-white hover:text-emerald-300 focus:outline-none transition-all duration-200" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://via.placeholder.com/30' }}" alt="Avatar" class="h-8 w-8 rounded-full border-2 border-emerald-300">
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 hidden transform opacity-0 scale-95 transition-all duration-300 ease-out" id="user-menu" role="menu">
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 hover:text-indigo-900 dark:hover:text-indigo-300 rounded-lg" role="menuitem" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-emerald-300 hover:scale-105 transition-all duration-200 px-3 py-2 rounded-md text-sm font-medium">Register</a>
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
                <a href="{{ route('users.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('users.*') ? 'bg-indigo-900' : '' }}">Users</a>
                <a href="{{ route('budgets.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('budgets.*') ? 'bg-indigo-900' : '' }}">Budgets</a>
                <a href="{{ route('approvals.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('approvals.*') ? 'bg-indigo-900' : '' }}">Approvals</a>
                <a href="{{ route('imports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('imports.*') ? 'bg-indigo-900' : '' }}">Imports</a>
                <a href="{{ route('reports.index') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium {{ Route::is('reports.*') ? 'bg-indigo-900' : '' }}">Reports</a>
                <a href="{{ route('logout') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-white hover:bg-indigo-900 hover:text-emerald-300 rounded-md text-base font-medium">Register</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Toggle user dropdown
    document.getElementById('user-menu-button')?.addEventListener('click', () => {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('scale-95');
    });

    // Toggle mobile menu
    document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
