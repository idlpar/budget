@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
        <!-- Back Button with Left Arrow on Top Right -->
        <a href="{{ route('budgets.index') }}" class="absolute top-4 right-4 inline-flex items-center px-6 py-3 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out shadow-lg">
            <!-- Left Arrow Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 19l-7-7 7-7"></path>
            </svg>
            Back
        </a>

        <h1 class="text-4xl font-semibold text-slate-800 dark:text-slate-200 mb-8 text-center">Upload Budget</h1>

        <form action="{{ route('budgets.upload') }}" method="POST" class="bg-white dark:bg-slate-800 p-10 rounded-xl shadow-xl space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Serial Field -->
                <div>
                    <label for="serial" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Serial</label>
                    <input type="text" name="serial" id="serial" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                </div>

                <!-- Account Code Field -->
                <div>
                    <label for="account_code" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Account Code</label>
                    <input type="text" name="account_code" id="account_code" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                </div>

                <!-- Account Head Field -->
                <div>
                    <label for="account_head_id" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Account Head</label>
                    <select name="account_head_id" id="account_head_id" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                        <option value="">Select Account Head</option>
                        @foreach ($accountHeads as $accountHead)
                            <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount Field -->
                <div>
                    <label for="amount" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Amount</label>
                    <input type="number" name="amount" id="amount" step="0.01" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                </div>

                <!-- Type Field -->
                <div>
                    <label for="type" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Type</label>
                    <select name="type" id="type" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                        <option value="estimated">Estimated</option>
                        <option value="revised">Revised</option>
                    </select>
                </div>

                <!-- Financial Year Field -->
                <div>
                    <label for="financial_year" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Financial Year (YYYY-YYYY)</label>
                    <input type="text" name="financial_year" id="financial_year" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                </div>

                <!-- Department Field -->
                <div>
                    <label for="department_id" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Department</label>
                    <select name="department_id" id="department_id" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Section Field -->
                <div>
                    <label for="section_id" class="block text-lg font-medium text-slate-700 dark:text-slate-300">Section</label>
                    <select name="section_id" id="section_id" class="mt-2 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition duration-200" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-8">
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-lg shadow-xl hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
