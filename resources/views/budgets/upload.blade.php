@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-2xl font-semibold text-gray-900">Upload Budget</h1>
        </div>
        <form action="{{ route('budgets.upload') }}" method="POST" class="px-4 py-5 sm:p-6">
            @csrf
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                <div>
                    <label for="serial" class="block text-sm font-medium text-gray-700">Serial</label>
                    <input type="text" name="serial" id="serial" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('serial') border-red-300 @enderror" value="{{ old('serial') }}" required>
                    @error('serial')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="account_code" class="block text-sm font-medium text-gray-700">Account Code</label>
                    <input type="text" name="account_code" id="account_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('account_code') border-red-300 @enderror" value="{{ old('account_code') }}" required>
                    @error('account_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('amount') border-red-300 @enderror" value="{{ old('amount') }}" step="0.01" required>
                    @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('type') border-red-300 @enderror" required>
                        <option value="estimated" {{ old('type') == 'estimated' ? 'selected' : '' }}>Estimated</option>
                        <option value="revised" {{ old('type') == 'revised' ? 'selected' : '' }}>Revised</option>
                    </select>
                    @error('type')
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
                            <option value="{{ $section->id }}" {{ old('section_id') == $section
