@extends('layouts.app')

@section('title', 'Upload Budget')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-2">Upload Budget</h1>
            <p class="text-slate-600 dark:text-slate-400">Fill in the budget details below</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <!-- Form Header with Gradient -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-slate-800 dark:to-slate-900">
                <h2 class="text-xl font-semibold text-white dark:text-slate-200">Budget Information</h2>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form action="{{ route('budgets.upload') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Serial Field -->
                        <div>
                            <label for="serial" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Serial Number</label>
                            <input type="text" name="serial" id="serial"
                                   placeholder="{{ $lastSerial ? 'Last serial was ' . $lastSerial : 'Enter serial number' }}"
                                   class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   required>
                            @error('serial')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Head Field -->
                        <div>
                            <label for="account_head_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Account Head</label>
                            <select name="account_head_id" id="account_head_id"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                <option value="">Select Account Head</option>
                                @forelse ($accountHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}">
                                        {{ $accountHead->name }} ({{ $accountHead->account_code }})
                                    </option>
                                @empty
                                    <option value="" disabled>No unused account heads available</option>
                                @endforelse
                            </select>
                            @error('account_head_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Amount (BDT)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 dark:text-slate-400">৳</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01"
                                       class="pl-8 w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       required>
                            </div>
                            <!-- Display Formatted Amount -->
                            <div id="formatted-amount" class="mt-2 text-sm text-slate-600 dark:text-slate-400"></div>
                            @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Budget Type Field -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Budget Type</label>
                            <select name="type" id="type"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                <option value="estimated">Estimated</option>
                                <option value="revised">Revised</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Financial Year Field -->
                        <div class="md:col-span-2">
                            <label for="financial_year" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Financial Year</label>
                            <div class="relative">
                                <select name="financial_year" id="financial_year"
                                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                    <option value="">Select Financial Year</option>
                                    @forelse ($financialYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @empty
                                        <option value="" disabled>No financial years available</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('financial_year')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Amount Formatting -->
    <script>
        document.getElementById('amount').addEventListener('input', function () {
            const amountInput = this.value;
            const formattedAmountDiv = document.getElementById('formatted-amount');

            // Clear output if input is empty or invalid
            if (!amountInput || isNaN(amountInput)) {
                formattedAmountDiv.textContent = '';
                return;
            }

            // Parse the input as a float
            const amount = parseFloat(amountInput);

            // Split into integer and decimal parts
            const [integerPart, decimalPart = ''] = Math.abs(amount).toFixed(2).split('.');
            let formattedInteger = integerPart;

            // Format integer part in Bangladeshi/Indian style (XX,XX,XXX)
            if (integerPart.length > 3) {
                const lastThree = integerPart.slice(-3);
                const otherNumbers = integerPart.slice(0, -3);
                formattedInteger = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + lastThree;
            }

            // Combine integer and decimal parts
            let formattedNumber = (amount < 0 ? '-' : '') + formattedInteger;
            if (decimalPart && parseInt(decimalPart) !== 0) {
                formattedNumber += '.' + decimalPart;
            }
            // Note: Not adding .00 for whole numbers since $showZeroDecimals = false by default

            // Display formatted amount with Taka symbol
            formattedAmountDiv.textContent = `Formatted Amount: ৳ ${formattedNumber}`;
        });
    </script>
@endsection
