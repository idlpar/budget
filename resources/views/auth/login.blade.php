@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('email')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                <input id="password" type="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('password')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded dark:bg-slate-800">
                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">Forgot your password?</a>
                @endif
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Login</button>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
