@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-2xl font-semibold text-gray-900">Post Approval</h1>
        </div>
        <form action="{{ route('approvals.store') }}" method="POST" class="px-4 py-5 sm:p-6">
            @csrf
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                <div>
                    <label for="account_head_id" class="block text-sm font-medium text-gray-700">Account Head</label>
                    <select name="account_head_id" id="account_head_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('account_head_id') border-red-300 @enderror" required>
                        <option value="">Select Account Head</option>
                        @foreach ($accountHeads as $head)
                            <option value="{{ $head->id }}" {{ old('account_head_id') == $head->id ? 'selected' : '' }}>{{ $head->name }}</option>
                        @endforeach
                    </select>
                    @error('account_head_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('department_id') border-red-300 @enderror" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                    <select name="section_id" id="section_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('section_id') border-red-300 @enderror" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('amount') border-red-300 @enderror" value="{{ old('amount') }}" step="0.01" required>
                    @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Transaction Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('transaction_date') border-red-300 @enderror" value="{{ old('transaction_date') }}" required>
                    @error('transaction_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Post</button>
            </div>
        </form>
    </div>
@endsection
