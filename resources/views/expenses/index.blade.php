@extends('layouts.app')
@section('title', 'Expense Report')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 dark:from-slate-900 dark:to-slate-800 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Expense Report</h2>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Filters -->
                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-8" id="filter-form">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                                <select name="division_id" id="division_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Divisions</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                                <select name="section_id" id="section_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Sections</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                                <select name="account_head_id" id="account_head_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Account Heads</option>
                                    @foreach($accountHeads as $accountHead)
                                        <option value="{{ $accountHead->id }}" {{ request('account_head_id') == $accountHead->id ? 'selected' : '' }}>{{ $accountHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                                <select name="report_type" id="report_type" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
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
                                <input type="date" name="date" id="date" value="{{ request('date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div id="custom-date-range" class="{{ request('report_type') == 'custom' ? '' : 'hidden' }}">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                        <div class="mt-6 flex flex-wrap gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">Apply Filters</button>
                            <button type="submit" name="export" value="csv" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">Export to CSV</button>
                            <a href="{{ route('expenses.create') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">Record New Expense</a>
                        </div>
                    </form>

                    <!-- Summary -->
                    <div class="mb-8 p-6 bg-gray-50 dark:bg-slate-700 rounded-lg shadow-inner">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Budget Summary</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <p class="text-lg font-medium text-blue-800 dark:text-blue-200">Total Expenses</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($totalExpenses, 2) }} BDT</p>
                            </div>
                            <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                                <p class="text-lg font-medium text-green-800 dark:text-green-200">Remaining Budgets</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach($remainingBudgets as $accountHeadId => $remaining)
                                        <li class="text-sm text-green-700 dark:text-green-300">
                                            {{ AccountHead::find($accountHeadId)->name }}:
                                            <span class="{{ $remaining >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ number_format($remaining, 2) }} BDT
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Expenses Table -->
                    <div class="overflow-x-auto">
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
                            @forelse($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->transaction_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->division->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->section ? $expense->section->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->accountHead->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($expense->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($expense->status == 'pending' && (auth()->user()->is_admin || auth()->user()->role == 'division_head' || auth()->user()->role == 'department_head'))
                                            <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-medium">Approve</button>
                                            </form>
                                            <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No expenses found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $expenses->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize dropdowns with selected values
        function initializeDropdowns() {
            const divisionId = '{{ request('division_id') }}';
            const departmentId = '{{ request('department_id') }}';
            const sectionId = '{{ request('section_id') }}';

            if (divisionId) {
                loadDepartments(divisionId, departmentId);
            }
            if (departmentId) {
                loadSections(departmentId, sectionId);
            }
        }

        // Load departments for a division
        function loadDepartments(divisionId, selectedDepartmentId) {
            const departmentSelect = document.getElementById('department_id');
            departmentSelect.innerHTML = '<option value="">All Departments</option>';

            if (divisionId) {
                fetch(`/api/divisions/${divisionId}/departments`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch departments: ${response.status}`);
                        return response.json();
                    })
                    .then(departments => {
                        departments.forEach(dept => {
                            const option = document.createElement('option');
                            option.value = dept.id;
                            option.textContent = dept.name;
                            if (dept.id == selectedDepartmentId) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching departments:', error);
                        departmentSelect.insertAdjacentHTML('afterend', '<p class="text-red-600 text-sm mt-1">Failed to load departments.</p>');
                    });
            }
        }

        // Load sections for a department
        function loadSections(departmentId, selectedSectionId) {
            const sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">All Sections</option>';

            if (departmentId) {
                fetch(`/api/departments/${departmentId}/sections`)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to fetch sections: ${response.status}`);
                        return response.json();
                    })
                    .then(sections => {
                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            if (section.id == selectedSectionId) {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching sections:', error);
                        sectionSelect.insertAdjacentHTML('afterend', '<p class="text-red-600 text-sm mt-1">Failed to load sections.</p>');
                    });
            }
        }

        // Dynamic organogram loading
        document.getElementById('division_id').addEventListener('change', function () {
            loadDepartments(this.value, '');
            document.getElementById('section_id').innerHTML = '<option value="">All Sections</option>';
        });

        document.getElementById('department_id').addEventListener('change', function () {
            loadSections(this.value, '');
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

        // Initialize dropdowns on page load
        initializeDropdowns();
    </script>
@endsection
