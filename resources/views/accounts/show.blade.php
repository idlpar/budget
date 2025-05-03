@extends('layouts.app')

@section('title', 'View Account Head')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 sm:py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Container -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Header Section -->
                <div class="px-6 py-5 sm:px-8 bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-500 dark:to-indigo-600">
                    <h1 class="text-2xl font-semibold text-white">Account Head Details</h1>
                    <p class="mt-1 text-sm text-indigo-100 dark:text-indigo-200">Detailed information about the account head</p>
                </div>
                <!-- Content Section -->
                <div class="px-6 py-6 sm:px-8 sm:py-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Account Code -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Account Code</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                @if (strlen($accountHead->account_code) === 10)
                                    {{ substr($accountHead->account_code, 0, 2) }}-{{ substr($accountHead->account_code, 2, 3) }}-{{ substr($accountHead->account_code, 5, 5) }}
                                @else
                                    {{ $accountHead->account_code }}
                                @endif
                            </p>
                        </div>
                        <!-- Name -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Name</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">{{ $accountHead->name }}</p>
                        </div>
                        <!-- Type -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Type</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($accountHead->type) }}</p>
                        </div>
                        <!-- Created By -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Created By</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">{{ $accountHead->creator ? $accountHead->creator->name : 'N/A' }}</p>
                        </div>
                        <!-- Created At -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Created At</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($accountHead->created_at)->timezone('Asia/Dhaka')->format('d-m-Y g:i A') }}
                            </p>
                        </div>
                        <!-- Updated By -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Updated By</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                {{ $accountHead->updater ? $accountHead->updater->name : 'N/A' }}
                            </p>
                        </div>
                        <!-- Updated At -->
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Updated At</p>
                            <p class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                {{ $accountHead->updated_at ? \Carbon\Carbon::parse($accountHead->updated_at)->timezone('Asia/Dhaka')->format('d-m-Y g:i A') : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- Change History Section -->
                    @if (auth()->user()->is_admin)
                        <div class="mt-10">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Change History</h2>
                            @if ($accountHead->changes->isEmpty())
                                <p class="text-sm text-gray-600 dark:text-gray-400">No changes recorded for this account head.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Field
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Old Value
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                New Value
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Changed By
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Changed At
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($accountHead->changes->sortByDesc('changed_at') as $change)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ ucfirst($change->field_name) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                    {{ ucfirst($change->old_value) ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                    {{ ucfirst($change->new_value) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                    {{ $change->changer ? $change->changer->name : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($change->changed_at)->timezone('Asia/Dhaka')->format('d-m-Y g:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('accounts.edit', $accountHead) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                Edit Account Head
                            </a>
                        @endif
                        <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
