@extends('layouts.app')

@section('title', 'Create Organizational Structure')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 py-12 sm:py-16 transition-colors duration-300">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Animated card container -->
            <div class="transform transition-all duration-500 hover:scale-[1.005]">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-slate-900/5 dark:ring-slate-200/10">
                    <!-- Card header with gradient -->
                    <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-white/10 backdrop-blur-sm mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Create Organizational Entity</h2>
                                <p class="mt-1 text-sm text-blue-100">Add new division, department or section to your structure</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card content -->
                    <div class="px-8 py-8">
                        <form method="POST" action="{{ route('organogram.store') }}" class="space-y-6">
                            @csrf

                            <!-- Form grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Type Field -->
                                <div class="md:col-span-2">
                                    <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                        <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded mr-2">Required</span>
                                        Entity Type
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select name="type" id="type" class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-200 px-4 py-3 border appearance-none group-hover:border-blue-400">
                                            <option value="division">Division</option>
                                            <option value="department">Department</option>
                                            <option value="section">Section</option>
                                        </select>
                                    </div>
                                    @error('type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Name Field -->
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                        <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded mr-2">Required</span>
                                        Entity Name
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                               class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-200 px-4 py-3 border group-hover:border-blue-400"
                                               placeholder="Enter entity name">
                                    </div>
                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Division Field -->
                                <div id="division-field">
                                    <label for="division_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        Parent Division
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select name="division_id" id="division_id" class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-200 px-4 py-3 border appearance-none group-hover:border-blue-400">
                                            <option value="">Select Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('division_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Department Field -->
                                <div id="department-field">
                                    <label for="department_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        Parent Department
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <select name="department_id" id="department_id" class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-200 px-4 py-3 border appearance-none group-hover:border-blue-400">
                                            <option value="">Select Department</option>
                                        </select>
                                    </div>
                                    @error('department_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form actions -->
                            <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-slate-200 dark:border-slate-600/50">
                                <a href="{{ route('organogram.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-lg text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="group relative inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30">
                                    <span class="mr-4">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </span>
                                    Create Entity
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const divisionField = document.getElementById('division-field');
            const departmentField = document.getElementById('department-field');
            const divisionSelect = document.getElementById('division_id');
            const departmentSelect = document.getElementById('department_id');

            function updateFieldVisibility() {
                const type = typeSelect.value;

                if (type === 'division') {
                    divisionField.style.display = 'none';
                    departmentField.style.display = 'none';
                    divisionSelect.disabled = true;
                    departmentSelect.disabled = true;
                } else if (type === 'department') {
                    divisionField.style.display = 'block';
                    departmentField.style.display = 'none';
                    divisionSelect.disabled = false;
                    departmentSelect.disabled = true;
                } else { // section
                    divisionField.style.display = 'block';
                    departmentField.style.display = 'block';
                    divisionSelect.disabled = false;
                    departmentSelect.disabled = false;
                }
            }

            // Initialize field visibility
            updateFieldVisibility();

            // Update on type change
            typeSelect.addEventListener('change', updateFieldVisibility);

            // Department dropdown population
            divisionSelect.addEventListener('change', function() {
                const divisionId = this.value;
                departmentSelect.innerHTML = '<option value="">Select Department</option>';

                if (divisionId && typeSelect.value === 'section') {
                    fetch(`/api/divisions/${divisionId}/departments`)
                        .then(response => response.json())
                        .then(departments => {
                            departments.forEach(dept => {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.name;
                                departmentSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
@endsection
