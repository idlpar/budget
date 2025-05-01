@extends('layouts.app')

@section('title', 'Account Heads')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Account Heads</h1>
            <div class="flex gap-2">
                <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Create Account Head</a>
                <a href="{{ route('accounts.import.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Import Accounts</a>
            </div>
        </div>
        <!-- Search Bar -->
        <div class="px-4 py-3 flex justify-center gap-2">
            <form method="GET" action="{{ route('accounts.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Account Code or Name..." class="w-64 px-4 py-2 text-sm text-slate-900 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Search</button>
            </form>
        </div>
        <!-- Filter Inputs -->
        <div class="pl-4 pr-0 py-3 flex gap-2">
            <form method="GET" action="{{ route('accounts.index') }}" class="w-full flex gap-2 flex-wrap">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <div class="flex items-center gap-2">
                    <label for="account_code" class="text-sm text-slate-700 dark:text-slate-300">Account Code:</label>
                    <input type="text" id="account_code" name="account_code" value="{{ request('account_code') }}" placeholder="Filter by code..." class="w-40 px-4 py-2 text-sm text-slate-900 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-center gap-2">
                    <label for="name" class="text-sm text-slate-700 dark:text-slate-300">Name:</label>
                    <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="Filter by name..." class="w-40 px-4 py-2 text-sm text-slate-900 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-center gap-2">
                    <label for="type" class="text-sm text-slate-700 dark:text-slate-300">Type:</label>
                    <select id="type" name="type" class="w-40 px-4 py-2 text-sm text-slate-900 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Apply Filters</button>
                    <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 dark:hover:bg-red-500">Clear Filters</a>
                </div>
            </form>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-600">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Sl No.</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Account Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Created By</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-700 divide-y divide-slate-200 dark:divide-slate-600">
                @forelse ($accountHeads as $index => $accountHead)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                            @if (strlen($accountHead->account_code) === 10)
                                {{ substr($accountHead->account_code, 0, 2) }}-{{ substr($accountHead->account_code, 2, 3) }}-{{ substr($accountHead->account_code, 5, 5) }}
                            @else
                                {{ $accountHead->account_code }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $accountHead->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $accountHead->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $accountHead->creator ? $accountHead->creator->name : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                            <!-- View Icon -->
                            <a href="{{ route('accounts.show', $accountHead) }}" title="View Account Head"
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            <!-- Divider -->
                            <div class="w-px h-5 bg-slate-300 dark:bg-slate-600"></div>

                            <!-- Edit Icon -->
                            <a href="{{ route('accounts.edit', $accountHead) }}" title="Edit Account Head"
                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor" viewBox="0 0 576 512" class="h-5 w-5 mr-1">
                                    <path d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"/>
                                </svg>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200 text-center">No account heads found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Total Heads Count -->
        <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-600 text-sm text-slate-700 dark:text-slate-300">
            Total Account Heads: {{ $totalHeads }}
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Filter script loaded'); // Debug: Confirm script is running
            const filterInputs = document.querySelectorAll('#filter-form input, #filter-form select');
            console.log('Found filter inputs:', filterInputs.length); // Debug: Confirm inputs are found
            filterInputs.forEach(input => {
                input.addEventListener('change', function () {
                    console.log('Filter input changed:', this.name, this.value);
                    document.getElementById('filter-form').submit();
                });
                input.addEventListener('keyup', function (event) {
                    if (event.key === 'Enter') {
                        console.log('Enter key pressed on filter input:', this.name, this.value);
                        document.getElementById('filter-form').submit();
                    }
                });
            });
        });
    </script>
@endpush
