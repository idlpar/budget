@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-2xl font-semibold text-gray-900">Reports</h1>
        </div>
        <form method="GET" action="{{ route('reports.index') }}" class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                <div>
                    <label for="filter_type" class="block text-sm font-medium text-gray-700">Filter By</label>
                    <select name="filter_type" id="filter_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('filter_type') border-red-300 @enderror">
                        <option value="department" {{ old('filter_type') == 'department' ? 'selected' : '' }}>Department</option>
                        <option value="section" {{ old('filter_type') == 'section' ? 'selected' : '' }}>Section</option>
                        <option value="account_head" {{ old('filter_type') == 'account_head' ? 'selected' : '' }}>Account Head</option>
                    </select>
                    @error('filter_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="filter_id" class="block text-sm font-medium text-gray-700">Select</label>
                    <select name="filter_id" id="filter_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('filter_id') border-red-300 @enderror">
                        <option value="">Select Option</option>
                    </select>
                    @error('filter_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="period" class="block text-sm font-medium text-gray-700">Period</label>
                    <select name="period" id="period" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('period') border-red-300 @enderror">
                        <option value="daily" {{ old('period') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="monthly" {{ old('period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ old('period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                    @error('period')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Generate Report</button>
            </div>
        </form>
    </div>
@endsection
