@extends('layouts.app')

@section('title', 'Import Account Heads')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg p-8 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6">Import Account Heads</h1>
        @if(session('success'))
            <div class="text-green-600 dark:text-green-400 mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="text-red-600 dark:text-red-400 mb-4">{{ session('error') }}</div>
        @endif

        @if (!$canImport)
            <p class="text-sm text-red-600 dark:text-red-400 mb-4">Account Heads have already been imported. Import is disabled.</p>
        @endif
        <form method="POST" action="{{ route('accounts.import') }}" enctype="multipart/form-data" {{ !$canImport ? 'disabled' : '' }}>
            @csrf
            <div class="grid gap-6">
                <div>
                    <label for="file" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Excel File (.xlsx or .xls)</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.xls" class="mt-1 block w-full text-sm text-slate-900 dark:text-slate-200 border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $canImport ? 'required' : 'disabled' }}>
                    @error('file')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-600 hover:bg-slate-300 dark:hover:bg-slate-500">Cancel</a>
                @if ($canImport)
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Import</button>
                @endif
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
