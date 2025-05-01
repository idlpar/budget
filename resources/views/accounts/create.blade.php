@extends('layouts.app')

@section('title', 'Create Account Head')

@section('content')
    <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl p-8 max-w-3xl mx-auto space-y-8">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-semibold text-slate-800 dark:text-white mb-6">Create Account Head</h1>
            <a href="{{ route('accounts.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 dark:bg-slate-500 dark:hover:bg-slate-400 transition">
                ← Back
            </a>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('accounts.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Account Code Field --}}
                <div class="flex flex-col">
                    <label for="account_code" class="text-base font-medium text-slate-600 dark:text-slate-300 mb-2">Account Code</label>
                    <input type="text" name="account_code" id="account_code" value="{{ old('account_code') }}" class="mt-1 block w-full rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3" required>
                    @error('account_code')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name Field --}}
                <div class="flex flex-col">
                    <label for="name" class="text-base font-medium text-slate-600 dark:text-slate-300 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3" required>
                    @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Type Field --}}
                <div class="flex flex-col">
                    <label for="type" class="text-base font-medium text-slate-600 dark:text-slate-300 mb-2">Type</label>
                    <input type="text" name="type" id="type" value="{{ old('type') }}" class="mt-1 block w-full rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3" required>
                    @error('type')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex justify-end gap-6">
                <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-600 hover:bg-slate-300 dark:hover:bg-slate-500 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium rounded-md bg-indigo-600 text-white hover:bg-indigo-700 dark:hover:bg-indigo-500 transition duration-200 ease-in-out">
                    Create
                </button>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
