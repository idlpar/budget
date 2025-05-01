@extends('layouts.app')

@section('title', 'Budgets')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Budgets</h1>
            <a href="{{ route('budgets.upload-form') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Upload Budget</a>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-600">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Serial</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Account Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Account Head</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Department</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Section</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Uploaded By</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Created At</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-700 divide-y divide-slate-200 dark:divide-slate-600">
                @foreach ($budgets as $budget)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ $budget->serial }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ $budget->account_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $budget->accountHead->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ number_format($budget->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ ucfirst($budget->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $budget->department->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $budget->section->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $budget->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ $budget->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection

