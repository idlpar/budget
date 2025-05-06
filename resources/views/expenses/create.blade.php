@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 dark:from-slate-900 dark:to-slate-800 py-8 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Expense Recording</h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Record and track organizational expenditures</p>
                <div class="mt-4 inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900/30 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-blue-800 dark:text-blue-200 font-medium">Financial Year: {{ $financialYear }}</span>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <!-- Progress Steps -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between px-8 py-4">
                        <div class="flex-1 flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium text-sm">1</div>
                                <div class="mt-2 text-xs font-medium text-blue-600 dark:text-blue-400">Basic Info</div>
                            </div>
                        </div>
                        <div class="flex-1 flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center font-medium text-sm">2</div>
                                <div class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">Budget Details</div>
                            </div>
                        </div>
                        <div class="flex-1 flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center font-medium text-sm">3</div>
                                <div class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">Review</div>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('expenses.store') }}" class="space-y-8" id="expense-form">
                    @csrf

                    <!-- Step 1: Basic Information -->
                    <div class="px-8 pt-6 pb-8">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Basic Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Financial Year -->
                            <div>
                                <label for="financial_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Financial Year *</label>
                                <div class="relative">
                                    <select name="financial_year" id="financial_year" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" onchange="this.form.action='{{ route('expenses.create') }}?financial_year='+this.value; this.form.submit();" required>
                                        @foreach($financialYears as $year)
                                            <option value="{{ $year }}" {{ $financialYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                @error('financial_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Transaction Date -->
                            <div>
                                <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction Date *</label>
                                <div class="relative">
                                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date') }}" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('transaction_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Budget Details -->
                    <div class="px-8 pt-6 pb-8 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Budget Details
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- Section -->
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Section</label>
                                <div class="relative">
                                    <select name="section_id" id="section_id" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <input type="hidden" name="department_id" id="department_id" value="{{ old('department_id') }}">
                                <input type="hidden" name="division_id" id="division_id" value="{{ old('division_id') }}">
                                @error('section_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <div id="section-hierarchy-display" class="mt-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 hidden"></div>
                            </div>

                            <!-- Department -->
                            <div>
                                <label for="department_id_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                                <div class="relative">
                                    <select name="department_id_alt" id="department_id_alt" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id_alt') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <input type="hidden" name="division_id_alt" id="division_id_alt_dept" value="{{ old('division_id_alt') }}">
                                @error('department_id_alt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <div id="department-hierarchy-display" class="mt-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 hidden"></div>
                            </div>

                            <!-- Division -->
                            <div>
                                <label for="division_id_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Division</label>
                                <div class="relative">
                                    <select name="division_id_alt" id="division_id_alt" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition">
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ old('division_id_alt') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                @error('division_id_alt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <div id="division-hierarchy-display" class="mt-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 hidden"></div>
                            </div>
                        </div>

                        <!-- Budget Heads -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white">Budget Allocation</h3>
                                <button type="button" id="add-budget-head" class="inline-flex items-center px-3.5 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Budget Head
                                </button>
                            </div>

                            <div id="budget-heads" class="space-y-4">
                                <div class="budget-head-entry grid grid-cols-1 md:grid-cols-12 gap-4 p-5 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget Head *</label>
                                        <div class="relative">
                                            <select name="budget_heads[0][account_head_id]" class="budget-head-select block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" required>
                                                @if($budgets->isEmpty())
                                                    <option value="">No active budgets found</option>
                                                @else
                                                    <option value="">Select Budget Head</option>
                                                    @foreach($budgets as $budget)
                                                        <option value="{{ $budget->account_head_id }}" data-budget-id="{{ $budget->id }}">{{ $budget->accountHead->name }} ({{ $budget->type }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('budget_heads.0.account_head_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="md:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount (BDT) *</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400">৳</span>
                                            </div>
                                            <input type="text" name="budget_heads[0][amount]" class="budget-head-amount pl-8 block w-full py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" value="{{ old('budget_heads.0.amount') }}" required>
                                            <input type="hidden" name="budget_heads[0][raw_amount]" class="budget-head-raw-amount" value="{{ old('budget_heads.0.raw_amount') }}">
                                        </div>
                                        @error('budget_heads.0.raw_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                        <span class="remaining-budget text-xs mt-2 block text-gray-500 dark:text-gray-400"></span>
                                    </div>
                                    <div class="md:col-span-2 flex justify-end items-center">
                                        <button type="button" class="remove-budget-head inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Remove</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            @error('budget_heads') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" class="block w-full px-3 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" rows="4" placeholder="Provide details about this expense...">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Submit Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Debounce utility
        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Format numbers in Bangladeshi style
        function bdNumber(number, decimalPlaces = 2, showZeroDecimals = true) {
            number = parseFloat(number) || 0;
            const parts = number.toFixed(decimalPlaces).split('.');
            let integerPart = parts[0];
            const decimalPart = parts[1] || '00';

            const lastThree = integerPart.slice(-3);
            const otherNumbers = integerPart.slice(0, -3);
            const formattedInteger = otherNumbers
                ? otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + lastThree
                : lastThree;

            return showZeroDecimals ? `${formattedInteger}.${decimalPart}` : formattedInteger;
        }

        // Add budget head dynamically
        document.getElementById('add-budget-head').addEventListener('click', function () {
            const container = document.getElementById('budget-heads');
            const index = container.children.length;
            const entry = document.createElement('div');
            entry.className = 'budget-head-entry grid grid-cols-1 md:grid-cols-12 gap-4 p-5 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600';
            entry.innerHTML = `
                <div class="md:col-span-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget Head *</label>
                    <div class="relative">
                        <select name="budget_heads[${index}][account_head_id]" class="budget-head-select block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" required>
                            @if($budgets->isEmpty())
            <option value="">No active budgets found</option>
@else
            <option value="">Select Budget Head</option>
@foreach($budgets as $budget)
            <option value="{{ $budget->account_head_id }}" data-budget-id="{{ $budget->id }}">{{ $budget->accountHead->name }} ({{ $budget->type }})</option>
                                @endforeach
            @endif
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
    <div class="md:col-span-5">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount (BDT) *</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 dark:text-gray-400">৳</span>
            </div>
            <input type="text" name="budget_heads[${index}][amount]" class="budget-head-amount pl-8 block w-full py-2.5 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-lg transition" value="" required>
                        <input type="hidden" name="budget_heads[${index}][raw_amount]" class="budget-head-raw-amount" value="">
                    </div>
                    <span class="remaining-budget text-xs mt-2 block text-gray-500 dark:text-gray-400"></span>
                </div>
                <div class="md:col-span-2 flex justify-end items-center">
                    <button type="button" class="remove-budget-head relative inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200 transform hover:scale-105">
                        <span>Remove</span>
                    </button>
                </div>

            `;
            container.appendChild(entry);
            updateRemoveButtons();
            attachBudgetListener(
                entry.querySelector('.budget-head-amount'),
                entry.querySelector('.budget-head-select'),
                entry.querySelector('.remaining-budget')
            );
            formatAmountInput(
                entry.querySelector('.budget-head-amount'),
                entry.querySelector('.budget-head-raw-amount')
            );
        });

        // Remove budget head
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-budget-head') || e.target.closest('.remove-budget-head')) {
                e.target.closest('.budget-head-entry').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const entries = document.querySelectorAll('.budget-head-entry');
            entries.forEach((entry, index) => {
                const removeButton = entry.querySelector('.remove-budget-head');
                removeButton.style.display = index === 0 ? 'none' : 'block';
            });
        }

        // Dynamic hierarchy loading based on Section
        document.getElementById('section_id').addEventListener('change', function () {
            const sectionId = this.value;
            const departmentInput = document.getElementById('department_id');
            const divisionInput = document.getElementById('division_id');
            const sectionHierarchyDisplay = document.getElementById('section-hierarchy-display');
            const departmentSelect = document.getElementById('department_id_alt');
            const divisionSelect = document.getElementById('division_id_alt');
            const departmentHierarchyDisplay = document.getElementById('department-hierarchy-display');
            const divisionHierarchyDisplay = document.getElementById('division-hierarchy-display');

            // Disable other dropdowns and clear their displays
            departmentSelect.disabled = !!sectionId;
            divisionSelect.disabled = !!sectionId;
            departmentHierarchyDisplay.classList.add('hidden');
            divisionHierarchyDisplay.classList.add('hidden');
            departmentSelect.value = '';
            divisionSelect.value = '';

            if (sectionId) {
                fetch(`/api/sections/${sectionId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch section details: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        departmentInput.value = data.department_id || '';
                        divisionInput.value = data.division_id || '';
                        sectionHierarchyDisplay.textContent = `Hierarchy: ${data.section_name} → ${data.department_name} → ${data.division_name}`;
                        sectionHierarchyDisplay.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Section fetch error:', error);
                        sectionHierarchyDisplay.textContent = 'Error loading hierarchy.';
                        sectionHierarchyDisplay.classList.remove('hidden');
                    });
            } else {
                departmentInput.value = '';
                divisionInput.value = '';
                sectionHierarchyDisplay.textContent = '';
                sectionHierarchyDisplay.classList.add('hidden');
                departmentSelect.disabled = false;
                divisionSelect.disabled = false;
                if (departmentSelect.value) {
                    departmentSelect.dispatchEvent(new Event('change'));
                } else if (divisionSelect.value) {
                    divisionSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Dynamic hierarchy loading based on Department
        document.getElementById('department_id_alt').addEventListener('change', function () {
            const departmentId = this.value;
            const divisionInput = document.getElementById('division_id_alt_dept');
            const departmentHierarchyDisplay = document.getElementById('department-hierarchy-display');
            const sectionSelect = document.getElementById('section_id');
            const divisionSelect = document.getElementById('division_id_alt');
            const sectionHierarchyDisplay = document.getElementById('section-hierarchy-display');
            const divisionHierarchyDisplay = document.getElementById('division-hierarchy-display');

            // Disable division dropdown and clear its display
            divisionSelect.disabled = !!departmentId;
            divisionHierarchyDisplay.classList.add('hidden');
            divisionSelect.value = '';

            if (departmentId) {
                fetch(`/api/departments/${departmentId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch department details: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        divisionInput.value = data.division_id || '';
                        departmentHierarchyDisplay.textContent = `Hierarchy: ${data.department_name} → ${data.division_name}`;
                        departmentHierarchyDisplay.classList.remove('hidden');
                        if (sectionSelect.value) {
                            sectionSelect.value = '';
                            sectionHierarchyDisplay.textContent = '';
                            sectionHierarchyDisplay.classList.add('hidden');
                            document.getElementById('department_id').value = '';
                            document.getElementById('division_id').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Department fetch error:', error);
                        departmentHierarchyDisplay.textContent = 'Error loading hierarchy.';
                        departmentHierarchyDisplay.classList.remove('hidden');
                    });
            } else {
                divisionInput.value = '';
                departmentHierarchyDisplay.textContent = '';
                departmentHierarchyDisplay.classList.add('hidden');
                divisionSelect.disabled = false;
                if (divisionSelect.value) {
                    divisionSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Dynamic hierarchy loading based on Division
        document.getElementById('division_id_alt').addEventListener('change', function () {
            const divisionId = this.value;
            const sectionSelect = document.getElementById('section_id');
            const departmentSelect = document.getElementById('department_id_alt');
            const sectionHierarchyDisplay = document.getElementById('section-hierarchy-display');
            const departmentHierarchyDisplay = document.getElementById('department-hierarchy-display');
            const divisionHierarchyDisplay = document.getElementById('division-hierarchy-display');

            // Disable other dropdowns and clear their displays
            sectionSelect.disabled = !!divisionId;
            departmentSelect.disabled = !!divisionId;
            sectionHierarchyDisplay.classList.add('hidden');
            departmentHierarchyDisplay.classList.add('hidden');

            sectionSelect.value = '';
            departmentSelect.value = '';
            document.getElementById('department_id').value = '';
            document.getElementById('division_id').value = '';
            document.getElementById('division_id_alt_dept').value = '';

            if (divisionId) {
                fetch(`/api/divisions/${divisionId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch division details: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        divisionHierarchyDisplay.textContent = `Hierarchy: ${data.name}`;
                        divisionHierarchyDisplay.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Division fetch error:', error);
                        divisionHierarchyDisplay.textContent = 'Error loading hierarchy.';
                        divisionHierarchyDisplay.classList.add('hidden');
                    });
            } else {
                divisionHierarchyDisplay.textContent = '';
                divisionHierarchyDisplay.classList.add('hidden');
                sectionSelect.disabled = false;
                departmentSelect.disabled = false;
                if (sectionSelect.value) {
                    sectionSelect.dispatchEvent(new Event('change'));
                } else if (departmentSelect.value) {
                    departmentSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Format amount input
        function formatAmountInput(amountInput, rawInput) {
            amountInput.addEventListener('input', function () {
                let value = this.value.replace(/[^0-9.]/g, '');
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                if (parts[1] && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].slice(0, 2);
                }

                const rawValue = parseFloat(value) || 0;
                rawInput.value = rawValue;
                this.value = value;
            });

            amountInput.addEventListener('blur', function () {
                const rawValue = parseFloat(this.value) || 0;
                this.value = rawValue ? bdNumber(rawValue, 2, true) : '';
                rawInput.value = rawValue;
            });
        }

        // Real-time budget remaining display
        function attachBudgetListener(amountInput, budgetHeadSelect, remainingSpan) {
            const updateRemainingBudget = debounce(function () {
                const budgetHeadId = budgetHeadSelect.value;
                const rawAmount = parseFloat(amountInput.parentElement.querySelector('.budget-head-raw-amount').value) || 0;
                const financialYear = document.getElementById('financial_year').value;

                if (budgetHeadId && financialYear) {
                    fetch(`/api/account-heads/${budgetHeadId}/remaining-budget?financial_year=${encodeURIComponent(financialYear)}`)
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) throw new Error(data.error);
                            const remainingBudget = data.remaining_budget - rawAmount;
                            const formattedRemaining = bdNumber(Math.abs(remainingBudget), 2, true);
                            remainingSpan.textContent = remainingBudget >= 0
                                ? `Remaining: ${formattedRemaining} BDT`
                                : `Exceeds by: ${formattedRemaining} BDT`;
                            remainingSpan.className = remainingBudget >= 0
                                ? 'remaining-budget text-xs mt-2 block text-green-600 dark:text-green-400'
                                : 'remaining-budget text-xs mt-2 block text-red-600 dark:text-red-400';
                        })
                        .catch(error => {
                            console.error('Budget fetch error:', error);
                            remainingSpan.textContent = `Unable to fetch budget: ${error.message}`;
                            remainingSpan.className = 'remaining-budget text-xs mt-2 block text-red-600 dark:text-red-400';
                        });
                } else {
                    remainingSpan.textContent = financialYear ? '' : 'Select a financial year';
                    remainingSpan.className = 'remaining-budget text-xs mt-2 block text-red-600 dark:text-red-400';
                }
            }, 500);

            amountInput.addEventListener('input', updateRemainingBudget);
            amountInput.addEventListener('blur', updateRemainingBudget);

            budgetHeadSelect.addEventListener('change', updateRemainingBudget);
        }

        // Client-side form validation and SweetAlert2 confirmation
        document.getElementById('expense-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const sectionId = document.getElementById('section_id').value;
            const departmentIdAlt = document.getElementById('department_id_alt').value;
            const divisionIdAlt = document.getElementById('division_id_alt').value;
            const financialYear = document.getElementById('financial_year').value;
            const transactionDate = document.getElementById('transaction_date').value;
            const description = document.getElementById('description').value;
            const budgetHeads = Array.from(document.querySelectorAll('.budget-head-entry')).map((entry, index) => {
                const select = entry.querySelector(`select[name="budget_heads[${index}][account_head_id]"]`);
                const amount = entry.querySelector(`input[name="budget_heads[${index}][raw_amount]"]`).value;
                return {
                    account_head: select.options[select.selectedIndex]?.text || 'N/A',
                    amount: amount ? bdNumber(parseFloat(amount), 2, true) : '0.00',
                };
            });

            if (!sectionId && !departmentIdAlt && !divisionIdAlt) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a section, department, or division.',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 rounded-2xl shadow-xl',
                        title: 'text-xl font-semibold text-gray-800 dark:text-white',
                        content: 'text-gray-600 dark:text-gray-300',
                        confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700',
                    },
                });
                return;
            }

            const hierarchyDisplay = sectionId
                ? document.getElementById('section-hierarchy-display').textContent
                : (departmentIdAlt
                    ? document.getElementById('department-hierarchy-display').textContent
                    : document.getElementById('division-hierarchy-display').textContent);

            const confirmationHtml = `
                <div class="text-left space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong class="text-gray-700 dark:text-gray-300">Financial Year:</strong>
                            <p class="text-gray-900 dark:text-gray-100">${financialYear}</p>
                        </div>
                        <div>
                            <strong class="text-gray-700 dark:text-gray-300">Transaction Date:</strong>
                            <p class="text-gray-900 dark:text-gray-100">${transactionDate}</p>
                        </div>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Hierarchy:</strong>
                        <p class="text-gray-900 dark:text-gray-100">${hierarchyDisplay || 'N/A'}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Expenses:</strong>
                        <ul class="list-disc pl-5">
                            ${budgetHeads.map(b => `<li>${b.account_head}: ${b.amount} BDT</li>`).join('')}
                        </ul>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Description:</strong>
                        <p class="text-gray-900 dark:text-gray-100">${description || 'N/A'}</p>
                    </div>
                </div>
            `;

            const result = await Swal.fire({
                title: 'Confirm Expense Details',
                html: confirmationHtml,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6',
                    title: 'text-xl font-semibold text-gray-800 dark:text-white mb-4',
                    htmlContainer: 'text-sm text-gray-600 dark:text-gray-300',
                    confirmButton: 'bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition',
                    cancelButton: 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition',
                },
                buttonsStyling: false,
                width: '40rem',
                padding: '2rem',
            });

            if (result.isConfirmed) {
                this.submit();
            }
        });

        // Attach listeners to initial fields
        document.querySelectorAll('.budget-head-entry').forEach(entry => {
            const amountInput = entry.querySelector('.budget-head-amount');
            const rawInput = entry.querySelector('.budget-head-raw-amount');
            const budgetHeadSelect = entry.querySelector('.budget-head-select');
            const remainingSpan = entry.querySelector('.remaining-budget');
            attachBudgetListener(amountInput, budgetHeadSelect, remainingSpan);
            formatAmountInput(amountInput, rawInput);
        });

        // Initialize remove buttons
        updateRemoveButtons();

        // Trigger initial hierarchy update
        document.getElementById('section_id').dispatchEvent(new Event('change'));
        document.getElementById('department_id_alt').dispatchEvent(new Event('change'));
        document.getElementById('division_id_alt').dispatchEvent(new Event('change'));
    </script>
@endsection
