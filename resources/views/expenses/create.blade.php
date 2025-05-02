@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Expense Submission</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Submit your expense details for processing</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Expense Details</h2>
            </div>

            <!-- Form Content -->
            <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Grid Layout for Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Account Head -->
                    <div class="space-y-2">
                        <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Account Head <span class="text-red-500">*</span>
                        </label>
                        <select name="account_head_id" id="account_head_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-100 transition duration-150 ease-in-out"
                                required>
                            <option value="">Select Account Head</option>
                            @foreach ($accountHeads as $accountHead)
                                <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Budget -->
                    <div class="space-y-2">
                        <label for="budget_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Budget <span class="text-red-500">*</span>
                        </label>
                        <select name="budget_id" id="budget_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-100 transition duration-150 ease-in-out"
                                required>
                            <option value="">Select Budget</option>
                            @foreach ($budgets as $budget)
                                <option value="{{ $budget->id }}">{{ $budget->serial }} ({{ $budget->financial_year }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Department -->
                    <div class="space-y-2">
                        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <select name="department_id" id="department_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-100 transition duration-150 ease-in-out"
                                required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="space-y-2">
                        <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Section <span class="text-red-500">*</span>
                        </label>
                        <select name="section_id" id="section_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-100 transition duration-150 ease-in-out"
                                required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="amount" id="amount" step="0.01"
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-3 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100 py-2"
                               placeholder="Enter amount" required>
                        <div id="formatted-amount" class="text-sm text-gray-500 dark:text-gray-400 mt-1 h-5"></div>
                    </div>

                    <!-- Transaction Date -->
                    <div class="space-y-2">
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Transaction Date <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="date" name="transaction_date" id="transaction_date"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-2 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="reset" class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Reset
                    </button>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Submit Expense
                    </button>
                </div>
            </form>
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

            // Display formatted amount
            formattedAmountDiv.textContent = `Formatted Amount: ৳ ${formattedNumber}`;
        });
    </script>
@endsection
