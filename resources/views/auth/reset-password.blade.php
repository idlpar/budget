
@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Reset Password</h2>
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('email')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">New Password</label>
                <input id="password" type="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('password')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Reset Password</button>
        </form>
    </div>
@endsection
