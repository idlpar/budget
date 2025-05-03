@extends('layouts.app')
@section('title', 'Expense Details')
@section('content')
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Expense Report</h2>

                    <!-- Filters -->
                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                                <select name="division_id" id="division_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">All Divisions</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">All Departments</option>
                                </select>
                            </div>
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                                <select name="section_id" id="section_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">All Sections</option>
                                </select>
                            </div>
                            <div>
                                <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                                <select name="account_head_id" id="account_head_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">All Account Heads</option>
                                    @foreach($accountHeads as $accountHead)
                                        <option value="{{ $accountHead->id }}" {{ request('account_head_id') == $accountHead->id ? 'selected' : '' }}>{{ $accountHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                                <select name="report_type" id="report_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="">Select Report Type</option>
                                    <option value="daily" {{ request('report_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ request('report_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ request('report_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ request('report_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    <option value="custom" {{ request('report_type') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                </select>
                            </div>
                            <div id="date-field" class="{{ request('report_type') == 'daily' ? '' : 'hidden' }}">
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                            </div>
                            <div id="custom-date-range" class="{{ request('report_type') == 'custom' ? '' : 'hidden' }}">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                            <button type="submit" name="export" value="csv" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Export to CSV</button>
                            <a href="{{ route('expenses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Record New Expense</a>
                        </div>
                    </form>

                    <!-- Summary -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Summary</h3>
                        <p class="text-gray-700 dark:text-gray-300">Total Expenses: {{ $totalExpenses }} BDT</p>
                        @foreach($remainingBudgets as $accountHeadId => $remaining)
                            <p class="text-gray-700 dark:text-gray-300">{{ AccountHead::find($accountHeadId)->name }} Remaining Budget: {{ $remaining }} BDT</p>
                        @endforeach
                    </div>

                    <!-- Expenses Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Division</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Account Head</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->transaction_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->division->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->section->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->transactionEntries->first()->accountHead->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if($expense->status == 'pending' && (auth()->user()->is_admin || auth()->user()->role == 'division_head' || auth()->user()->role == 'department_head'))
                                        <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-800">Approve</button>
                                        </form>
                                        <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Reject</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $expenses->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic organogram loading
        document.getElementById('division_id').addEventListener('change', function () {
            const divisionId = this.value;
            const departmentSelect = document.getElementById('department_id');
            const sectionSelect = document.getElementById('section_id');

            departmentSelect.innerHTML = '<option value="">All Departments</option>';
            sectionSelect.innerHTML = '<option value="">All Sections</option>';

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

            sectionSelect.innerHTML = '<option value="">All Sections</option>';

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

        // Show/hide date fields based on report type
        document.getElementById('report_type').addEventListener('change', function () {
            const reportType = this.value;
            const dateField = document.getElementById('date-field');
            const customDateRange = document.getElementById('custom-date-range');

            dateField.classList.add('hidden');
            customDateRange.classList.add('hidden');

            if (reportType === 'daily') {
                dateField.classList.remove('hidden');
            } else if (reportType === 'custom') {
                customDateRange.classList.remove('hidden');
            }
        });
    </script>
@endsection
