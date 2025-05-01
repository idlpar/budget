@extends('layouts.app')

@section('title', 'Budget Details')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Container for Budget Details -->
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl overflow-hidden border border-slate-300 dark:border-slate-600">
            <!-- Header with gradient background -->
            <div class="px-6 py-5 sm:px-8 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-slate-800 dark:to-slate-900">
                <h1 class="text-3xl font-bold text-white dark:text-slate-100">Budget Details</h1>
                <p class="mt-1 text-blue-100 dark:text-slate-300">Financial allocation details</p>
            </div>

            <!-- Main content -->
            <div class="border-t border-slate-200 dark:border-slate-600 p-6 sm:p-8">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    <!-- Serial -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Serial</dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-200">{{ $budget->serial }}</dd>
                    </div>

                    <!-- Account Code -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Account Code</dt>
                        <dd class="mt-1 text-lg font-semibold text-blue-600 dark:text-blue-400">
                            @if (strlen($budget->account_code) === 10)
                                {{ substr($budget->account_code, 0, 2) }}-{{ substr($budget->account_code, 2, 3) }}-{{ substr($budget->account_code, 5, 5) }}
                            @else
                                {{ $budget->account_code }}
                            @endif
                        </dd>
                    </div>

                    <!-- Account Head -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Account Head</dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-200">{{ $budget->accountHead->name }}</dd>
                    </div>

                    <!-- Account Type -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Account Type</dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-200">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $budget->accountHead->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }}">
                                {{ $budget->accountHead->type }}
                            </span>
                        </dd>
                    </div>

                    <!-- Amount -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Amount (BDT)</dt>
                        <dd class="mt-1 text-2xl font-bold text-slate-900 dark:text-slate-100 font-mono">
                            {{ \App\Helpers\NumberHelper::bdNumber($budget->amount) }}
                        </dd>
                    </div>

                    <!-- Budget Type -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Budget Type</dt>
                        <dd class="mt-1 text-lg font-semibold">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                {{ $budget->type === 'estimated' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' }}">
                                {{ ucfirst($budget->type) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Uploaded By -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Uploaded By</dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $budget->user->name }}
                        </dd>
                    </div>

                    <!-- Created At -->
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Created At</dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $budget->created_at->format('M j, Y') }}
                        </dd>
                    </div>
                </dl>

                <!-- Action Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                    <!-- Edit Button -->
                    <a href="{{ route('budgets.edit', $budget) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Budget
                    </a>

                    <!-- Secondary Actions -->
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <!-- Print Button -->
                        <button onclick="window.print()"
                                class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-base font-medium rounded-md shadow-sm text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print
                        </button>

                        <!-- Back Button -->
                        <a href="{{ route('budgets.index') }}"
                           class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-slate-600 hover:bg-slate-700 dark:bg-slate-500 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Budgets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
