@extends('layouts.app')

@section('title', 'Budget Management System')

@section('content')
    <div class="bg-white dark:bg-slate-800 shadow-xl rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700">
        <!-- Header with Actions -->
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-slate-800 dark:to-slate-900 border-b border-slate-200 dark:border-slate-700">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-2xl font-bold text-white dark:text-slate-100">Budget Management System</h1>
                    <p class="text-blue-100 dark:text-slate-400 mt-1">Comprehensive financial planning and tracking</p>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                    <a href="{{ route('budgets.upload-form') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Budget
                    </a>
                    <a href="{{ route('budgets.import.form') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Import Budgets
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
            <div class="mb-4">
                <form method="GET" action="{{ route('budgets.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="account_search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Search Accounts</label>
                        <div class="relative">
                            <input type="text" name="account_search" id="account_search" value="{{ request('account_search') }}"
                                   class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Account ID or Name">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="per_page" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Items Per Page</label>
                        <select name="per_page" id="per_page" onchange="this.form.submit()"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 per page</option>
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show All</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-150">
                            Search
                        </button>
                        <a href="{{ route('budgets.index') }}" class="ml-2 inline-flex items-center justify-center px-4 py-2 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-md shadow-sm text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors duration-150">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-slate-700 rounded-lg shadow-xs p-4">
                <form method="GET" action="{{ route('budgets.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-8 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Serial</label>
                            <input type="text" name="serial" value="{{ request('serial') }}" placeholder="Filter Serial"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Account Code</label>
                            <input type="text" name="account_code" value="{{ request('account_code') }}" placeholder="Filter Code"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Account Head</label>
                            <input type="text" name="account_head" value="{{ request('account_head') }}" placeholder="Filter Head"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Amount</label>
                            <input type="number" name="amount" value="{{ request('amount') }}" placeholder="Filter Amount"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Budget Type</label>
                            <select name="type" class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                                <option value="">All Types</option>
                                <option value="estimated" {{ request('type') == 'estimated' ? 'selected' : '' }}>Estimated</option>
                                <option value="revised" {{ request('type') == 'revised' ? 'selected' : '' }}>Revised</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Uploaded By</label>
                            <input type="text" name="uploaded_by" value="{{ request('uploaded_by') }}" placeholder="Filter Uploader"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Date Range</label>
                            <input type="date" name="created_at" value="{{ request('created_at') }}"
                                   class="w-full text-sm rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-150">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                    <!-- Preserve per_page in filter form -->
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Serial</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Account Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Account Head</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Account Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Amount (BDT)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Uploaded By</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Created At</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                @forelse ($budgets as $budget)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">{{ $budget->serial }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 dark:text-blue-400">
                            @if (strlen($budget->account_code) === 10)
                                {{ substr($budget->account_code, 0, 2) }}-{{ substr($budget->account_code, 2, 3) }}-{{ substr($budget->account_code, 5, 5) }}
                            @else
                                {{ $budget->account_code }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-200">{{ $budget->accountHead->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">{{ $budget->accountHead->type ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300 font-mono text-right">
                            {{ \App\Helpers\NumberHelper::bdNumber($budget->amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $budget->type === 'estimated' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' }}">
                                {{ ucfirst($budget->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-200">{{ $budget->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">{{ $budget->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('budgets.show', $budget) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('budgets.edit', $budget) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                            No budgets found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary and Pagination -->
        <div class="border-t border-slate-200 dark:border-slate-700">
            <!-- Account Type Totals -->
            @if(!empty($totalsByAccountType))
                <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ($totalsByAccountType as $type => $total)
                            <div class="bg-white dark:bg-slate-700 p-3 rounded-lg shadow-xs">
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $type ?? 'Unknown' }}</div>
                                <div class="mt-1 text-lg font-semibold text-slate-800 dark:text-slate-200 font-mono">{{  \App\Helpers\NumberHelper::bdNumber($total) }} BDT</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            <div class="px-6 py-3 flex flex-col md:flex-row items-center justify-between bg-white dark:bg-slate-800">
                <div class="text-sm text-slate-600 dark:text-slate-300 mb-2 md:mb-0">
                    @if(request('per_page') === 'all')
                        Showing all {{ $budgets->count() }} entries
                    @else
                        Showing {{ $budgets->firstItem() ?? 0 }} to {{ $budgets->lastItem() ?? 0 }} of {{ $budgets->total() }} entries
                    @endif
                </div>
                <div class="flex items-center space-x-1">
                    @if(request('per_page') !== 'all')
                        {{ $budgets->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
