@extends('layouts.app')

@section('title', 'Verify Email Address')

@section('content')
    <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Verify Your Email Address</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 text-center">A verification link has been sent to your email address. Please check your inbox and click the link to verify.</p>
        @if (session('resent'))
            <p class="text-sm text-green-600 dark:text-green-400 mb-4 text-center">A new verification link has been sent to your email address.</p>
        @endif
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Resend Verification Email</button>
        </form>
    </div>
@endsection
