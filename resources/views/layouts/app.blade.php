<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Budget Control') }} - @yield('title', 'Home')</title>
   @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-100 dark:bg-slate-900 font-sans antialiased">
<div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content with Optional Sidebar -->
    <div class="flex flex-1">
        @if (auth()->check() && !in_array(Route::currentRouteName(), ['login', 'register', 'password.request', 'password.reset', 'verification.notice']))
            <!-- Sidebar for authenticated users on non-auth pages -->
            <x-sidebar />
            <main class="flex-1 p-6 lg:p-8 bg-slate-50 dark:bg-slate-800 transition-all duration-300">
                @yield('content')
            </main>
        @else
            <!-- Full-width content for public or auth pages -->
            <main class="flex-1 p-6 lg:p-8 bg-slate-50 dark:bg-slate-800">
                @yield('content')
            </main>
        @endif
    </div>
</div>

<script src="{{ asset('js/bootstrap.js') }}"></script>
@stack('scripts')

<x-footer />
</body>
</html>
