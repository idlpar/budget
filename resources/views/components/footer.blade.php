<footer class="bg-slate-800 dark:bg-slate-900 text-white py-8">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Company Info -->
            <div>
                <div class="flex items-center mb-4">
                    <svg class="h-8 w-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Bakhrabad Gas Distribution Company Limited Logo">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 6v6" />
                    </svg>
                    <span class="text-lg font-semibold">Budget Control</span>
                </div>
                <p class="text-slate-300 dark:text-slate-400 text-sm mb-4">Bakhrabad Gas Distribution Company Limited</p>
                <p class="text-slate-300 dark:text-slate-400 text-sm mb-4">Delivering Reliable Gas Distribution and Financial Excellence</p>
                <div class="flex space-x-3">
                    <a href="https://facebook.com" target="_blank" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200" aria-label="Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" /></svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200" aria-label="Twitter">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" /></svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200" aria-label="LinkedIn">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" /><circle cx="4" cy="4" r="2" /></svg>
                    </a>
                </div>
            </div>
            <!-- Quick Links -->
            <div>
                <h3 class="text-base font-semibold text-white mb-3">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Home</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Dashboard</a></li>
                        <li><a href="{{ route('budgets.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Budgets</a></li>
                        <li><a href="{{ route('approvals.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Approvals</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Register</a></li>
                    @endif
                </ul>
            </div>
            <!-- Services -->
            <div>
                <h3 class="text-base font-semibold text-white mb-3">Our Services</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('budgets.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Budget Management</a></li>
                    <li><a href="{{ route('approvals.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Daily Approvals</a></li>
                    <li><a href="{{ route('imports.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Data Imports</a></li>
                    <li><a href="{{ route('reports.index') }}" class="text-slate-300 hover:text-emerald-400 transition-colors duration-200 text-sm">Reports</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-6 border-t border-slate-700 pt-4 text-center">
            <p class="text-slate-300 text-sm">© {{ date('Y') }} Bakhrabad Gas Distribution Company Limited. All rights reserved.</p>
        </div>
    </div>
</footer>
