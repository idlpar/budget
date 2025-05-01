@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Submit New Expense</h1>
        <form action="{{ route('expenses.store') }}" method="POST" class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="account_head_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                    <select name="account_head_id" id="account_head_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                        <option value="">Select Account Head</option>
                        @foreach ($accountHeads as $accountHead)
                            <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="budget_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget</label>
                    <select name="budget_id" id="budget_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                        <option value="">Select Budget</option>
                        @foreach ($budgets as $budget)
                            <option value="{{ $budget->id }}">{{ $budget->serial }} ({{ $budget->financial_year }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section</label>
                    <select name="section_id" id="section_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                    <input type="number" name="amount" id="amount" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                </div>
                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-gray-100" required>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Submit</button>
            </div>
        </form>
    </div>
@endsection
