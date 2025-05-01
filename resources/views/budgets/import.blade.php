@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Budget Data Import</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Upload and manage budget allocations for your organization</p>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                <a href="{{ route('budgets.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Estimated Budget Import Card -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-700 dark:to-slate-900 p-6 rounded-xl shadow-md mb-8 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Estimated Budget Import</h2>
            </div>

            <form action="{{ route('budgets.import.estimated') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="financial_year_estimated" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Financial Year</label>
                        <input type="text" name="financial_year" id="financial_year_estimated" value="{{ old('financial_year') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white"
                               placeholder="e.g., 2023-2024">
                        @error('financial_year') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select name="department_id" id="department_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white"
                                onchange="fetchSections(this.value)">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section</label>
                        <select name="section_id" id="section_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white">
                            <option value="">Select Section</option>
                        </select>
                        @error('section_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="file_estimated" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Excel File</label>
                        <div class="relative">
                            <input type="file" name="file" id="file_estimated"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-200
                                          hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                        </div>
                        @error('file') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Import Estimated Budget
                    </button>
                </div>
            </form>
        </div>

        <!-- Revised Budget Import Card -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-slate-700 dark:to-slate-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-4">
                <div class="bg-amber-100 dark:bg-amber-900 p-2 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Revised Budget Import</h2>
            </div>

            <form action="{{ route('budgets.import.revised') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="financial_year_revised" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Financial Year</label>
                        <input type="text" name="financial_year" id="financial_year_revised" value="{{ old('financial_year') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-800 dark:text-white"
                               placeholder="e.g., 2023-2024">
                        @error('financial_year') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="file_revised" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Excel File</label>
                        <div class="relative">
                            <input type="file" name="file" id="file_revised"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-amber-50 file:text-amber-700 dark:file:bg-amber-900 dark:file:text-amber-200
                                          hover:file:bg-amber-100 dark:hover:file:bg-amber-800">
                        </div>
                        @error('file') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Import Revised Budget
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        async function fetchSections(departmentId) {
            if (!departmentId) {
                document.getElementById('section_id').innerHTML = '<option value="">Select Section</option>';
                return;
            }

            try {
                const response = await fetch(`/api/sections?department_id=${departmentId}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const sections = await response.json();
                const sectionSelect = document.getElementById('section_id');

                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    sectionSelect.appendChild(option);
                });

            } catch (error) {
                console.error('Error fetching sections:', error);
                // You might want to show a user-friendly error message here
            }
        }
    </script>
@endsection
