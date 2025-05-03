@extends('layouts.app')

@section('title', 'Import Account Heads')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-12 sm:py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Animated card container -->
            <div class="transform transition-all duration-500 hover:scale-[1.005]">
                <div class="bg-white dark:bg-slate-700 rounded-2xl shadow-xl overflow-hidden ring-1 ring-slate-900/5 dark:ring-slate-200/10">
                    <!-- Card header with gradient -->
                    <div class="px-6 py-5 bg-gradient-to-r from-indigo-600 to-blue-500">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Import Account Heads
                            </h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white/90">
                                Excel Format
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-indigo-100">
                            Upload your account heads file to import into the system
                        </p>
                    </div>

                    <!-- Card content -->
                    <div class="px-6 py-8 sm:p-8">
                        <form method="POST" action="{{ route('accounts.import') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- File upload area with drag and drop styling -->
                            <div class="space-y-2">
                                <label for="file" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Select Excel File
                                    <span class="text-slate-400 dark:text-slate-500 text-xs">(.xlsx, .xls)</span>
                                </label>

                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl transition-all duration-300 hover:border-indigo-400 hover:bg-slate-50/50 dark:hover:bg-slate-600/20">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 dark:text-slate-400">
                                            <label for="file" class="relative cursor-pointer rounded-md bg-white dark:bg-slate-800 font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 mx-auto">
                                                <span>Upload a file</span>
                                                <input id="file" name="file" type="file" accept=".xlsx,.xls" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            or drag and drop
                                        </p>
                                    </div>
                                </div>

                                @error('file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Import button with loading state -->
                            <div class="pt-4">
                                <button type="submit" class="group relative w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    Import Account Heads
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Help section -->
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-600/30 border-t border-slate-200 dark:border-slate-600/50">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 dark:text-indigo-400 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300">Need help with formatting?</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    Download our <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">template file</a> to ensure proper formatting.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
