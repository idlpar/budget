@extends('layouts.app')

@section('title', 'Service Unavailable')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-slate-900">
        <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg p-8 max-w-md w-full text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-slate-800 dark:text-slate-200 mb-4">503 - Service Unavailable</h1>
            <p class="text-slate-600 dark:text-slate-400 mb-6">We're currently undergoing maintenance. Please check back soon.</p>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Return to Dashboard</a>
        </div>
    </div>
@endsection
