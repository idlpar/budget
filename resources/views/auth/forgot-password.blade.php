@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <section class="py-16 bg-slate-50 dark:bg-slate-800">
        <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Forgot Password</h2>
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                    {{ session('status') }}
                </div>
            @endif
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 text-center">Enter your email address to receive a password reset link.</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                    @error('email')
                    <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Email Password Reset Link</button>
            </form>
        </div>
    </section>
@endsection
