@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 dark:from-slate-900 dark:to-slate-800 py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Record New Expense</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Fill in the details below to record a new expense</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900/30 rounded-lg p-2">
                            <span class="text-blue-800 dark:text-blue-200 font-medium">FY: {{ $financialYear }}</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6" id="expense-form">
                        @csrf

                        <!-- Financial Year and Date Section -->
                        <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Financial Year -->
                                <div>
                                    <label for="financial_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Financial Year *</label>
                                    <select name="financial_year" id="financial_year" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" onchange="this.form.action='{{ route('expenses.create') }}?financial_year='+this.value; this.form.submit();" required>
                                        @foreach($financialYears as $year)
                                            <option value="{{ $year }}" {{ $financialYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    @error('financial_year') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Transaction Date -->
                                <div>
                                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transaction Date *</label>
                                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date') }}" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" required>
                                    @error('transaction_date') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Organizational Hierarchy Section -->
                        <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Organizational Hierarchy</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Section -->
                                <div>
                                    <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section</label>
                                    <select name="section_id" id="section_id" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="department_id" id="department_id" value="{{ old('department_id') }}">
                                    <input type="hidden" name="division_id" id="division_id" value="{{ old('division_id') }}">
                                    @error('section_id') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                    <div id="hierarchy-display" class="mt-2 text-xs text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 p-2 rounded border border-gray-200 dark:border-slate-600"></div>
                                </div>

                                <!-- Department Alternative -->
                                <div>
                                    <label for="department_id_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department (Alternative)</label>
                                    <select name="department_id_alt" id="department_id_alt" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id_alt') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="division_id_alt" id="division_id_alt" value="{{ old('division_id_alt') }}">
                                    @error('department_id_alt') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                    <div id="department-hierarchy-display" class="mt-2 text-xs text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 p-2 rounded border border-gray-200 dark:border-slate-600"></div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Note: Please select either a Section or a Department</p>
                        </div>

                        <!-- Budget Heads Section -->
                        <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Budget Allocation</h3>
                                <button type="button" id="add-budget-head" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Budget Head
                                </button>
                            </div>

                            <div id="budget-heads" class="space-y-3">
                                <div class="budget-head-entry grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 bg-white dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                                    <div class="sm:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget Head *</label>
                                        <select name="budget_heads[0][account_head_id]" class="budget-head-select w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" required>
                                            @if($budgets->isEmpty())
                                                <option value="">No active budgets found</option>
                                            @else
                                                <option value="">Select Budget Head</option>
                                                @foreach($budgets as $budget)
                                                    <option value="{{ $budget->account_head_id }}" data-budget-id="{{ $budget->id }}">{{ $budget->accountHead->name }} ({{ $budget->type }})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('budget_heads.0.account_head_id') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="sm:col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (BDT) *</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400 text-sm">৳</span>
                                            <input type="text" name="budget_heads[0][amount]" class="budget-head-amount pl-8 w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" value="{{ old('budget_heads.0.amount') }}" required>
                                            <input type="hidden" name="budget_heads[0][raw_amount]" class="budget-head-raw-amount" value="{{ old('budget_heads.0.raw_amount') }}">
                                        </div>
                                        @error('budget_heads.0.raw_amount') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                                        <span class="remaining-budget text-xs mt-1 block"></span>
                                    </div>
                                    <div class="sm:col-span-2 flex items-end">
                                        <button type="button" class="remove-budget-head w-full inline-flex justify-center items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition" style="display: none;">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('budget_heads') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description Section -->
                        <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Additional Information</h3>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea name="description" id="description" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" rows="4" placeholder="Enter any additional details about this expense...">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Record Expense
                            </button>
                        </div>
                    </form>
                </div>
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
            entry.className = 'budget-head-entry grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 bg-white dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600';
            entry.innerHTML = `
                <div class="sm:col-span-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget Head *</label>
                    <select name="budget_heads[${index}][account_head_id]" class="budget-head-select w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" required>
                        @if($budgets->isEmpty())
            <option value="">No active budgets found</option>
@else
            <option value="">Select Budget Head</option>
@foreach($budgets as $budget)
            <option value="{{ $budget->account_head_id }}" data-budget-id="{{ $budget->id }}">{{ $budget->accountHead->name }} ({{ $budget->type }})</option>
                            @endforeach
            @endif
            </select>
        </div>
        <div class="sm:col-span-5">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (BDT) *</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400 text-sm">৳</span>
                <input type="text" name="budget_heads[${index}][amount]" class="budget-head-amount pl-8 w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition text-sm py-2.5" value="" required>
                        <input type="hidden" name="budget_heads[${index}][raw_amount]" class="budget-head-raw-amount">
                    </div>
                    <span class="remaining-budget text-xs mt-1 block"></span>
                </div>
                <div class="sm:col-span-2 flex items-end">
                    <button type="button" class="remove-budget-head w-full inline-flex justify-center items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(entry);
            updateRemoveButtons();
            attachBudgetListener(entry.querySelector('.budget-head-amount'), entry.querySelector('.budget-head-select'), entry.querySelector('.remaining-budget'));
            formatAmountInput(entry.querySelector('.budget-head-amount'), entry.querySelector('.budget-head-raw-amount'));
        });

        // Remove budget head
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-budget-head')) {
                e.target.closest('.budget-head-entry').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const entries = document.querySelectorAll('.budget-head-entry');
            entries.forEach((entry, index) => {
                const removeButton = entry.querySelector('.remove-budget-head');
                removeButton.style.display = index === 0 ? 'none' : 'flex';
            });
        }

        // Dynamic hierarchy loading based on Section
        document.getElementById('section_id').addEventListener('change', function () {
            const sectionId = this.value;
            const departmentInput = document.getElementById('department_id');
            const divisionInput = document.getElementById('division_id');
            const hierarchyDisplay = document.getElementById('hierarchy-display');
            const departmentAltSelect = document.getElementById('department_id_alt');
            const departmentHierarchyDisplay = document.getElementById('department-hierarchy-display');

            departmentAltSelect.disabled = !!sectionId;

            if (sectionId) {
                fetch(`/api/sections/${sectionId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch section details: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Section fetch response:', data);
                        departmentInput.value = data.department_id || '';
                        divisionInput.value = data.division_id || '';
                        hierarchyDisplay.textContent = `${data.section_name} → ${data.department_name} → ${data.division_name}`;
                        departmentAltSelect.value = '';
                        departmentHierarchyDisplay.textContent = '';
                    })
                    .catch(error => {
                        console.error('Section fetch error:', error);
                        hierarchyDisplay.textContent = 'Error loading hierarchy.';
                    });
            } else {
                departmentInput.value = '';
                divisionInput.value = '';
                hierarchyDisplay.textContent = '';
                departmentAltSelect.disabled = false;
                if (departmentAltSelect.value) {
                    departmentAltSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Dynamic hierarchy loading based on Department
        document.getElementById('department_id_alt').addEventListener('change', function () {
            const departmentId = this.value;
            const divisionInput = document.getElementById('division_id_alt');
            const departmentHierarchyDisplay = document.getElementById('department-hierarchy-display');
            const sectionSelect = document.getElementById('section_id');
            const hierarchyDisplay = document.getElementById('hierarchy-display');

            console.log('Department selected:', departmentId);

            if (departmentId) {
                fetch(`/api/departments/${departmentId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch department details: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Department fetch response:', data);
                        divisionInput.value = data.division_id || '';
                        departmentHierarchyDisplay.textContent = `${data.department_name} → ${data.division_name}`;
                        if (sectionSelect.value) {
                            sectionSelect.value = '';
                            hierarchyDisplay.textContent = '';
                            document.getElementById('department_id').value = '';
                            document.getElementById('division_id').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Department fetch error:', error);
                        departmentHierarchyDisplay.textContent = 'Error loading hierarchy.';
                    });
            } else {
                divisionInput.value = '';
                departmentHierarchyDisplay.textContent = '';
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
                                ? `Remaining: ৳${formattedRemaining}`
                                : `Exceeds by: ৳${formattedRemaining}`;
                            remainingSpan.className = remainingBudget >= 0
                                ? 'remaining-budget text-xs text-green-600 dark:text-green-400 mt-1 block'
                                : 'remaining-budget text-xs text-red-600 dark:text-red-400 mt-1 block';
                        })
                        .catch(error => {
                            console.error('Budget fetch error:', error);
                            remainingSpan.textContent = `Unable to fetch budget: ${error.message}`;
                            remainingSpan.className = 'remaining-budget text-xs text-red-600 dark:text-red-400 mt-1 block';
                        });
                } else {
                    remainingSpan.textContent = financialYear ? '' : 'Select a financial year';
                    remainingSpan.className = 'remaining-budget text-xs text-red-600 dark:text-red-400 mt-1 block';
                }
            }, 500);

            amountInput.addEventListener('input', updateRemainingBudget);
            amountInput.addEventListener('blur', updateRemainingBudget);

            budgetHeadSelect.addEventListener('change', function () {
                console.log('Budget head selected:', this.value);
                updateRemainingBudget();
            });
        }

        // Client-side form validation and SweetAlert2 confirmation
        document.getElementById('expense-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const sectionId = document.getElementById('section_id').value;
            const departmentId = document.getElementById('department_id').value;
            const departmentIdAlt = document.getElementById('department_id_alt').value;
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

            if (!sectionId && !departmentIdAlt) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select either a section or a department.',
                });
                return;
            }

            const hierarchyDisplay = sectionId
                ? document.getElementById('hierarchy-display').textContent
                : document.getElementById('department-hierarchy-display').textContent;

            const confirmationHtml = `
                <div class="text-left space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Financial Year</p>
                            <p class="text-sm">${financialYear}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Transaction Date</p>
                            <p class="text-sm">${transactionDate}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Hierarchy</p>
                        <p class="text-sm">${hierarchyDisplay || 'N/A'}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Expenses</p>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            ${budgetHeads.map(b => `
                                <li class="py-2 flex justify-between">
                                    <span>${b.account_head}</span>
                                    <span class="font-medium">৳${b.amount}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="text-sm">${description || 'N/A'}</p>
                    </div>
                </div>
            `;

            const result = await Swal.fire({
                title: 'Confirm Expense Details',
                html: confirmationHtml,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirm & Submit',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#DC2626',
                width: '600px',
                customClass: {
                    popup: 'text-left',
                    confirmButton: 'px-4 py-2 text-sm font-medium',
                    cancelButton: 'px-4 py-2 text-sm font-medium'
                }
            });

            if (result.isConfirmed) {
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;

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
    </script>
@endsection
