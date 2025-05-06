<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Budget Control') }} - @yield('title', 'Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-200 font-sans antialiased">
<div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content with Optional Sidebar -->
    <div class="flex flex-1">
        @if (auth()->check() && !in_array(Route::currentRouteName(), ['home', 'login', 'register', 'password.request', 'password.reset', 'verification.notice', 'password.confirm', 'verification.verify']))
            <!-- Sidebar for authenticated users on non-excluded pages -->
            <x-sidebar />
            <main class="flex-1 p-2 lg:p-4 bg-slate-50 dark:bg-slate-800 transition-all duration-300">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        @else
            <!-- Full-width content for public or auth pages -->
            <main class="flex-1 p-6 lg:p-8 bg-slate-50 dark:bg-slate-800">
                @yield('content')
            </main>
        @endif
    </div>

    <!-- Footer -->
   <x-footer />
</div>

@stack('scripts')
</body>
</html>
