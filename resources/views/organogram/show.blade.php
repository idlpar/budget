@extends('layouts.app')
@section('title', 'Show Organizational Structure')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 py-12 sm:py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="transform transition-all duration-500 hover:scale-[1.005]">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-slate-900/5 dark:ring-slate-200/10">
                    <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-teal-600">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-white/10 backdrop-blur-sm mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">Change History for {{ ucfirst($type) }}: {{ $entity->name }}</h2>
                                    <p class="mt-1 text-sm text-green-100">View all recorded changes for this {{ $type }}</p>
                                </div>
                            </div>
                            <a href="{{ route('organogram.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-white/20 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Back to Index
                            </a>
                        </div>
                    </div>

                    <div class="px-8 py-8">
                        @if ($changes->isEmpty())
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <p>No changes recorded for this {{ $type }}.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($changes as $change)
                                    <div class="bg-white dark:bg-slate-700/50 rounded-lg shadow-md p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Field: {{ $change->field_name }}</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Old Value: {{ $change->old_value ?? 'N/A' }}</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">New Value: {{ $change->new_value ?? 'N/A' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Changed by: {{ $change->changer->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $change->created_at->format('Y-m-d H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
