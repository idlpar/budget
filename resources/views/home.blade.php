@extends('layouts.app')

@section('title', 'Welcome to Bakhrabad Gas Distribution Company Limited')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-indigo-600 to-emerald-500 dark:from-indigo-900 dark:to-emerald-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Bakhrabad Gas Distribution Company Limited Logo">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 6v6" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Bakhrabad Gas Distribution Company Limited</h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">Streamline your financial operations with our advanced budget control system, designed for efficiency and precision.</p>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-indigo-100 hover:scale-105 transition-all duration-300">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-indigo-100 hover:scale-105 transition-all duration-300">Login</a>
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-emerald-500 text-white font-semibold rounded-lg shadow-lg hover:bg-emerald-600 hover:scale-105 transition-all duration-300">Register</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-slate-50 dark:bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-200 text-center mb-12">Why Choose Our System?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-slate-700 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                    <svg class="h-10 w-10 text-indigo-600 dark:text-indigo-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 text-center mb-2">Budget Management</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-center">Track and manage budgets with real-time insights and detailed reports.</p>
                </div>
                <div class="bg-white dark:bg-slate-700 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                    <svg class="h-10 w-10 text-indigo-600 dark:text-indigo-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 text-center mb-2">Daily Approvals</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-center">Streamline approval processes with automated workflows.</p>
                </div>
                <div class="bg-white dark:bg-slate-700 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                    <svg class="h-10 w-10 text-indigo-600 dark:text-indigo-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 text-center mb-2">Comprehensive Reports</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-center">Generate detailed reports to monitor financial performance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-indigo-100 dark:bg-indigo-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-4">Ready to Get Started?</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">Join Bakhrabad Gas Distribution Company Limited to manage your budgets efficiently.</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-emerald-500 text-white font-semibold rounded-lg shadow-lg hover:bg-emerald-600 hover:scale-105 transition-all duration-300">Sign Up Now</a>
        </div>
    </section>
@endsection

@section('footer')
    <x-footer />
@endsection
