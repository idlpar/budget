@extends('layouts.app')

@section('title', 'Edit Budget')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-2">Edit Budget</h1>
            <p class="text-slate-600 dark:text-slate-400">Update the budget details below</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <!-- Form Header with Gradient -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-slate-800 dark:to-slate-900">
                <h2 class="text-xl font-semibold text-white dark:text-slate-200">Budget Information</h2>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('budgets.update', $budget) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Serial Field -->
                        <div>
                            <label for="serial" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Serial Number</label>
                            <input type="text" name="serial" id="serial" value="{{ old('serial', $budget->serial) }}"
                                   class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('serial')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Head Field -->
                        <div>
                            <label for="account_head_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Account Head</label>
                            <select name="account_head_id" id="account_head_id"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Account Head</option>
                                @foreach ($accountHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}" {{ old('account_head_id', $budget->account_head_id) == $accountHead->id ? 'selected' : '' }}>
                                        {{ $accountHead->name }} ({{ $accountHead->account_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_head_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Amount (BDT)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 dark:text-slate-400">৳</span>
                                </div>
                                <input type="text" name="amount" id="amount"
                                       value="{{ old('amount', \App\Helpers\NumberHelper::bdNumber($budget->amount)) }}"
                                       class="pl-8 w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Budget Type Field -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Budget Type</label>
                            <select name="type" id="type"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="estimated" {{ old('type', $budget->type) == 'estimated' ? 'selected' : '' }}>Estimated</option>
                                <option value="revised" {{ old('type', $budget->type) == 'revised' ? 'selected' : '' }}>Revised</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Financial Year Field -->
                        <div class="md:col-span-2">
                            <label for="financial_year" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Financial Year</label>
                            <input type="text" name="financial_year" id="financial_year"
                                   value="{{ old('financial_year', $budget->financial_year) }}"
                                   placeholder="YYYY-YYYY"
                                   class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('financial_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6">
                        <a href="{{ route('budgets.index') }}"
                           class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
