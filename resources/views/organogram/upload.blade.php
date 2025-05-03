@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 sm:py-16 transition-all duration-500">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Glowing card container -->
            <div class="relative group">
                <!-- Glow effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-purple-600 rounded-2xl opacity-20 group-hover:opacity-30 blur-lg transition-all duration-500"></div>

                <!-- Premium card -->
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden ring-1 ring-white/10 dark:ring-slate-600/20 backdrop-blur-sm">
                    <!-- Card header with gradient and floating elements -->
                    <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-indigo-600 relative overflow-hidden">
                        <!-- Floating circles decoration -->
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 rounded-full bg-white/10 backdrop-blur-sm"></div>
                        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 rounded-full bg-white/5 backdrop-blur-sm"></div>

                        <div class="relative z-10 flex items-center">
                            <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm mr-4 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Import Organogram</h2>
                                <p class="mt-1 text-sm text-blue-100">Upload your organizational structure</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card content with animated file upload -->
                    <div class="px-8 py-8">
                        <form method="POST" action="{{ route('organogram.upload.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Drag and drop file upload area -->
                            <div x-data="{ isDragging: false }"
                                 @dragenter="isDragging = true"
                                 @dragleave="isDragging = false"
                                 @drop="isDragging = false"
                                 class="mt-1 flex justify-center px-6 pt-10 pb-12 border-2 border-dashed rounded-2xl transition-all duration-300"
                                 :class="isDragging ? 'border-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-slate-300 dark:border-slate-600 hover:border-blue-300 dark:hover:border-blue-500'">
                                <div class="space-y-3 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-600 dark:text-slate-400">
                                        <label for="file" class="relative cursor-pointer rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file" name="file" type="file" accept=".xlsx,.xls" class="sr-only" @change="isDragging = false">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Excel files only (.xlsx, .xls)
                                    </p>
                                </div>
                            </div>
                            @error('file')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror

                            <!-- Form actions -->
                            <div class="flex items-center justify-center pt-6">
                                <button type="submit" class="group relative inline-flex items-center justify-center px-8 py-3 overflow-hidden text-sm font-medium rounded-full text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl shadow-indigo-500/30">
                                    <span class="absolute left-0 -ml-4 h-full flex items-center">
                                        <svg class="h-5 w-5 text-white opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span class="relative">Import Structure</span>
                                    <span class="absolute right-0 -mr-4 h-full flex items-center">
                                        <svg class="h-5 w-5 text-white opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:-translate-x-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Help section -->
                    <div class="px-8 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-600/50">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 dark:text-indigo-400 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300">Need the template?</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    Download our <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">Excel template</a> for proper formatting.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
