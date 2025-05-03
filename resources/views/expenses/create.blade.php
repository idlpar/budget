@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Record Expense</h2>

                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                                <select name="division_id" id="division_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">Select Department</option>
                                </select>
                                @error('department_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                                <select name="section_id" id="section_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">Select Section</option>
                                </select>
                                @error('section_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date</label>
                                <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                @error('transaction_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Account Heads</h3>
                            <div id="account-heads">
                                <div class="account-head-entry grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="account_heads[0][account_head_id]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                                        <select name="account_heads[0][account_head_id]" class="account-head-select mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                            @foreach($accountHeads as $accountHead)
                                                <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('account_heads.0.account_head_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="account_heads[0][amount]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (BDT)</label>
                                        <input type="number" name="account_heads[0][amount]" step="0.01" class="account-head-amount mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                        @error('account_heads.0.amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                        <span class="remaining-budget text-sm text-green-600 dark:text-green-400"></span>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="remove-account-head bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700" style="display: none;">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-account-head" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Account Head</button>
                            @error('account_heads') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100" rows="4">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Record Expense</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add account head dynamically
        document.getElementById('add-account-head').addEventListener('click', function () {
            const container = document.getElementById('account-heads');
            const index = container.children.length;
            const entry = document.createElement('div');
            entry.className = 'account-head-entry grid grid-cols-1 md:grid-cols-3 gap-4 mb-4';
            entry.innerHTML = `
                <div>
                    <label for="account_heads[${index}][account_head_id]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                    <select name="account_heads[${index}][account_head_id]" class="account-head-select mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                        @foreach($accountHeads as $accountHead)
            <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                        @endforeach
            </select>
        </div>
        <div>
            <label for="account_heads[${index}][amount]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (BDT)</label>
                    <input type="number" name="account_heads[${index}][amount]" step="0.01" class="account-head-amount mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                    <span class="remaining-budget text-sm text-green-600 dark:text-green-400"></span>
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-account-head bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Remove</button>
                </div>
            `;
            container.appendChild(entry);
            updateRemoveButtons();
            attachBudgetListener(entry.querySelector('.account-head-amount'), entry.querySelector('.account-head-select'), entry.querySelector('.remaining-budget'));
        });

        // Remove account head
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-account-head')) {
                e.target.closest('.account-head-entry').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const entries = document.querySelectorAll('.account-head-entry');
            entries.forEach((entry, index) => {
                const removeButton = entry.querySelector('.remove-account-head');
                removeButton.style.display = index === 0 ? 'none' : 'block';
            });
        }

        // Dynamic organogram loading
        document.getElementById('division_id').addEventListener('change', function () {
            const divisionId = this.value;
            const departmentSelect = document.getElementById('department_id');
            const sectionSelect = document.getElementById('section_id');

            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (divisionId) {
                fetch(`/api/divisions/${divisionId}/departments`)
                    .then(response => response.json())
                    .then(departments => {
                        departments.forEach(dept => {
                            const option = document.createElement('option');
                            option.value = dept.id;
                            option.textContent = dept.name;
                            departmentSelect.appendChild(option);
                        });
                    });
            }
        });

        document.getElementById('department_id').addEventListener('change', function () {
            const departmentId = this.value;
            const sectionSelect = document.getElementById('section_id');

            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (departmentId) {
                fetch(`/api/departments/${departmentId}/sections`)
                    .then(response => response.json())
                    .then(sections => {
                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            sectionSelect.appendChild(option);
                        });
                    });
            }
        });

        // Real-time budget remaining display
        function attachBudgetListener(amountInput, accountHeadSelect, remainingSpan) {
            amountInput.addEventListener('input', function () {
                const accountHeadId = accountHeadSelect.value;
                const amount = parseFloat(amountInput.value) || 0;

                if (accountHeadId) {
                    fetch(`/api/account-heads/${accountHeadId}/remaining-budget`)
                        .then(response => response.json())
                        .then(data => {
                            const remainingBudget = data.remaining_budget - amount;
                            remainingSpan.textContent = remainingBudget >= 0
                                ? `Remaining Budget: ${remainingBudget.toFixed(2)} BDT`
                                : `Exceeds Budget by: ${Math.abs(remainingBudget).toFixed(2)} BDT`;
                            remainingSpan.className = remainingBudget >= 0
                                ? 'remaining-budget text-sm text-green-600 dark:text-green-400'
                                : 'remaining-budget text-sm text-red-600 dark:text-red-400';
                        })
                        .catch(() => {
                            remainingSpan.textContent = 'Unable to fetch budget.';
                            remainingSpan.className = 'remaining-budget text-sm text-red-600 dark:text-red-400';
                        });
                } else {
                    remainingSpan.textContent = '';
                }
            });

            // Trigger on account head change
            accountHeadSelect.addEventListener('change', function () {
                amountInput.dispatchEvent(new Event('input'));
            });
        }

        // Attach budget listeners to initial fields
        document.querySelectorAll('.account-head-entry').forEach(entry => {
            const amountInput = entry.querySelector('.account-head-amount');
            const accountHeadSelect = entry.querySelector('.account-head-select');
            const remainingSpan = entry.querySelector('.remaining-budget');
            attachBudgetListener(amountInput, accountHeadSelect, remainingSpan);
        });
    </script>
@endsection
