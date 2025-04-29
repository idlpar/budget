@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-2xl font-semibold text-gray-900">Import Data</h1>
        </div>
        <form action="{{ route('imports.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-5 sm:p-6">
            @csrf
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                <div>
                    <label for="table" class="block text-sm font-medium text-gray-700">Select Table</label>
                    <select name="table" id="table" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('table') border-red-300 @enderror" required>
                        <option value="">Select Table</option>
                        <option value="budgets" {{ old('table') == 'budgets' ? 'selected' : '' }}>Budgets</option>
                        <option value="employee_costs" {{ old('table') == 'employee_costs' ? 'selected' : '' }}>Employee Costs</option>
                    </select>
                    @error('table')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Upload Excel File</label>
                    <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('file') border-red-300 @enderror" accept=".xlsx,.xls" required>
                    @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Import</button>
            </div>
        </form>
    </div>
@endsection
