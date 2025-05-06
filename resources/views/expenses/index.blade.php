```blade
@extends('layouts.app')

@section('title', 'Expense Report')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-100 dark:from-slate-900 dark:to-slate-800 py-8 sm:py-12">
        <div class="max-w-max mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800 p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-white">Expense Report</h2>
                    <div class="flex gap-4">
                        <a href="{{ route('expenses.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-blue-50 transition">Record New Expense</a>
                        <button type="submit" form="filter-form" name="export" value="csv" class="bg-white text-green-600 px-4 py-2 rounded-lg font-medium hover:bg-green-50 transition">Export to CSV</button>
                        <button onclick="window.print()" class="bg-white text-gray-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition">Print Report</button>
                    </div>
                </div>

                <div class="p-6">
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
                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6" id="filter-form">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                                <select name="division_id" id="division_id" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Divisions</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                                <select name="section_id" id="section_id" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Sections</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                                <select name="account_head_id" id="account_head_id" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">All Account Heads</option>
                                    @foreach($accountHeads as $accountHead)
                                        <option value="{{ $accountHead->id }}" {{ request('account_head_id') == $accountHead->id ? 'selected' : '' }}>{{ $accountHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                                <select name="report_type" id="report_type" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
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
                                <input type="date" name="date" id="date" value="{{ request('date') }}" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div id="custom-date-range" class="{{ request('report_type') == 'custom' ? '' : 'hidden' }}">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full p-2 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition">Apply Filters</button>
                        </div>
                    </form>

                    <!-- Summary -->
                    <div class="mb-6 p-6 bg-gray-50 dark:bg-slate-700 rounded-lg shadow-inner">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Budget Summary</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <p class="text-lg font-medium text-blue-800 dark:text-blue-200">Approved Total ({{ $expenses->where('status', 'approved')->count() }})</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($expenses->where('status', 'approved')->sum('amount'), 2) }} BDT</p>
                            </div>
                            <div class="p-4 bg-red-100 dark:bg-red-900 rounded-lg">
                                <p class="text-lg font-medium text-red-800 dark:text-red-200">Rejected Total ({{ $expenses->where('status', 'rejected')->count() }})</p>
                                <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ number_format($expenses->where('status', 'rejected')->sum('amount'), 2) }} BDT</p>
                            </div>
                            <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                                <p class="text-lg font-medium text-green-800 dark:text-green-200">Remaining Budgets</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach($remainingBudgets as $accountHeadId => $remaining)
                                        <li class="text-sm text-green-700 dark:text-green-300">
                                            {{ \App\Models\AccountHead::find($accountHeadId)->name }}:
                                            <span class="{{ $remaining >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ number_format($remaining, 2) }} BDT
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Actions and Table Header -->
                    <div class="sticky top-0 bg-white dark:bg-slate-800 z-10 pb-4">
                        <div class="flex gap-4 mb-4">
                            <button id="bulk-approve-btn" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition opacity-50 cursor-not-allowed" disabled>
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Bulk Approve
                            </button>
                            <button id="bulk-reject-btn" class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition opacity-50 cursor-not-allowed" disabled>
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Bulk Reject
                            </button>
                        </div>
                        <form id="bulk-action-form" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="expense_ids" id="expense-ids">
                            <input type="hidden" name="action" id="bulk-action">
                        </form>
                    </div>

                    <!-- Expenses Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600 printable-table">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Division</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Account Head</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Post Creator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Approved By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider no-print">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                            @forelse($expenses as $expense)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($expense->status == 'pending' && (auth()->user()->is_admin || auth()->user()->role == 'division_head' || auth()->user()->role == 'department_head'))
                                            <input type="checkbox" name="expense_ids[]" value="{{ $expense->id }}" class="expense-checkbox rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                                        @else
                                            <input type="checkbox" disabled class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500 opacity-50">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($expense->transaction_date)->format('d F, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->division ? $expense->division->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department ? $expense->department->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->section ? $expense->section->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->accountHead->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $expense->status == 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($expense->status == 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                                                {{ ucfirst($expense->status) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->user ? $expense->user->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->approved_by ? \App\Models\User::find($expense->approved_by)->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 no-print">
                                        @if($expense->status == 'pending' && (auth()->user()->is_admin || auth()->user()->role == 'division_head' || auth()->user()->role == 'department_head'))
                                            <button onclick="confirmAction('approve', '{{ route('expenses.approve', $expense) }}')" class="text-green-600 hover:text-green-800 font-medium">Approve</button>
                                            <button onclick="confirmAction('reject', '{{ route('expenses.reject', $expense) }}')" class="text-red-600 hover:text-red-800 font-medium ml-2">Reject</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No expenses found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 no-print">
                        {{ $expenses->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                font-size: 12pt;
            }
            .printable-table {
                width: 100%;
                border-collapse: collapse;
            }
            .printable-table th, .printable-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .printable-table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }
            .no-print, .no-print * {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // SweetAlert2 for single and bulk actions
        function confirmAction(action, url) {
            Swal.fire({
                title: `Confirm ${action === 'approve' ? 'Approval' : 'Rejection'}`,
                text: `Are you sure you want to ${action} this expense?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action} it`,
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 rounded-2xl shadow-xl',
                    title: 'text-xl font-semibold text-gray-800 dark:text-white',
                    content: 'text-gray-600 dark:text-gray-300',
                    confirmButton: `bg-${action === 'approve' ? 'green' : 'red'}-600 text-white px-4 py-2 rounded-lg hover:bg-${action === 'approve' ? 'green' : 'red'}-700`,
                    cancelButton: 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Bulk action handling
        const selectAllCheckbox = document.getElementById('select-all');
        const expenseCheckboxes = document.querySelectorAll('.expense-checkbox');
        const bulkApproveBtn = document.getElementById('bulk-approve-btn');
        const bulkRejectBtn = document.getElementById('bulk-reject-btn');
        const bulkActionForm = document.getElementById('bulk-action-form');
        const expenseIdsInput = document.getElementById('expense-ids');
        const bulkActionInput = document.getElementById('bulk-action');

        function updateBulkButtons() {
            const checkedCount = document.querySelectorAll('.expense-checkbox:checked').length;
            bulkApproveBtn.disabled = checkedCount === 0;
            bulkRejectBtn.disabled = checkedCount === 0;
            bulkApproveBtn.classList.toggle('opacity-50', checkedCount === 0);
            bulkApproveBtn.classList.toggle('cursor-not-allowed', checkedCount === 0);
            bulkRejectBtn.classList.toggle('opacity-50', checkedCount === 0);
            bulkRejectBtn.classList.toggle('cursor-not-allowed', checkedCount === 0);
        }

        selectAllCheckbox.addEventListener('change', function () {
            expenseCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkButtons();
        });

        expenseCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                selectAllCheckbox.checked = false;
                updateBulkButtons();
            });
        });

        function handleBulkAction(action) {
            const selectedIds = Array.from(document.querySelectorAll('.expense-checkbox:checked')).map(cb => cb.value);
            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'Please select at least one expense.',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 rounded-2xl shadow-xl',
                        title: 'text-xl font-semibold text-gray-800 dark:text-white',
                        content: 'text-gray-600 dark:text-gray-300',
                        confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700',
                    },
                });
                return;
            }

            Swal.fire({
                title: `Confirm ${action === 'approve' ? 'Approval' : 'Rejection'}`,
                text: `Are you sure you want to ${action} ${selectedIds.length} expense${selectedIds.length > 1 ? 's' : ''}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action} them`,
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 rounded-2xl shadow-xl',
                    title: 'text-xl font-semibold text-gray-800 dark:text-white',
                    content: 'text-gray-600 dark:text-gray-300',
                    confirmButton: `bg-${action === 'approve' ? 'green' : 'red'}-600 text-white px-4 py-2 rounded-lg hover:bg-${action === 'approve' ? 'green' : 'red'}-700`,
                    cancelButton: 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.isConfirmed) {
                    expenseIdsInput.value = selectedIds.join(',');
                    bulkActionInput.value = action;
                    bulkActionForm.action = action === 'approve' ? '{{ route('expenses.bulk-approve') }}' : '{{ route('expenses.bulk-reject') }}';
                    bulkActionForm.submit();
                }
            });
        }

        bulkApproveBtn.addEventListener('click', () => handleBulkAction('approve'));
        bulkRejectBtn.addEventListener('click', () => handleBulkAction('reject'));

        // Initialize dropdowns and bulk buttons on page load
        initializeDropdowns();
        updateBulkButtons();
    </script>
@endsection
```
