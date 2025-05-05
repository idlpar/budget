@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 dark:from-slate-900 dark:to-slate-800 py-8 sm:py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Expense Reports</h2>

                    <!-- Filters -->
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                            <select name="division_id" id="division_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="">All Divisions</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                            <select name="department_id" id="department_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                            <select name="section_id" id="section_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget Head</label>
                            <select name="account_head_id" id="account_head_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="">All Budget Heads</option>
                                @foreach($accountHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}" {{ request('account_head_id') == $accountHead->id ? 'selected' : '' }}>{{ $accountHead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                            <select name="report_type" id="report_type" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $reportType == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $reportType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="custom" {{ $reportType == 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>
                        <div id="custom_date" class="{{ $reportType == 'custom' ? '' : 'hidden' }}">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                        </div>
                        <div id="custom_date_end" class="{{ $reportType == 'custom' ? '' : 'hidden' }}">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                            <a href="{{ route('expenses.index', ['export' => 1, 'division_id' => request('division_id'), 'department_id' => request('department_id'), 'section_id' => request('section_id'), 'account_head_id' => request('account_head_id'), 'report_type' => $reportType, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="ml-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Export CSV</a>
                        </div>
                    </form>

                    <!-- Expense Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Division</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Budget Head</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount (BDT)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->transaction_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->transaction_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->division->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->department->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->section->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->accountHead->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $expense->transaction->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($expense->status == 'pending' && auth()->user()->can('approve', $expense))
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
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $expenses->links() }}
                    </div>

                    <!-- Summary -->
                    <div class="mt-8">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Expenses: {{ number_format($totalExpenses, 2) }} BDT</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Remaining Budgets:</p>
                        <ul class="list-disc pl-5 text-sm text-gray-600 dark:text-gray-400">
                            @foreach($remainingBudgets as $accountHeadId => $remaining)
                                <li>{{ AccountHead::find($accountHeadId)->name }}: {{ number_format($remaining, 2) }} BDT</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('report_type').addEventListener('change', function () {
            const customDate = document.getElementById('custom_date');
            const customDateEnd = document.getElementById('custom_date_end');
            if (this.value === 'custom') {
                customDate.classList.remove('hidden');
                customDateEnd.classList.remove('hidden');
            } else {
                customDate.classList.add('hidden');
                customDateEnd.classList.add('hidden');
            }
        });
    </script>
@endsection
