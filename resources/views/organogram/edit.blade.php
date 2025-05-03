@extends('layouts.app')

@section('title', 'Edit Organizational Structure')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 py-12 sm:py-16 transition-colors duration-300">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Premium card container with subtle animation -->
            <div class="transform transition-all duration-500 hover:scale-[1.005]">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-slate-900/5 dark:ring-slate-200/10">
                    <!-- Premium gradient header with glossy effect -->
                    <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 rounded-full bg-white/10 backdrop-blur-sm"></div>
                        <div class="relative z-10 flex items-start">
                            <div class="p-3 rounded-lg bg-white/10 backdrop-blur-sm mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Edit {{ ucfirst($type) }}</h2>
                                <p class="mt-1 text-sm text-indigo-100">Update {{ ucfirst($type) }} details and hierarchy</p>
                            </div>
                        </div>
                    </div>

                    <!-- Premium form content -->
                    <div class="px-8 py-8 bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm">
                        <form method="POST" action="{{ route('organogram.update', ['type' => $type, 'id' => $entity->id]) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Premium form grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name Field -->
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                        <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded mr-2">Required</span>
                                        {{ ucfirst($type) }} Name
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name"
                                               value="{{ old('name', $entity->name) }}"
                                               class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200 px-4 py-3 border group-hover:border-indigo-400"
                                               placeholder="Enter {{ $type }} name">
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

                                @if ($type === 'department' || $type === 'section')
                                    <!-- Division Field -->
                                    <div>
                                        <label for="division_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                            <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded mr-2">Required</span>
                                            Division
                                        </label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <select name="division_id" id="division_id" class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200 px-4 py-3 border appearance-none group-hover:border-indigo-400">
                                                <option value="">Select Division</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}" {{ ($type === 'section' ? $entity->department->division_id : $entity->division_id) == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
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
                                @endif

                                @if ($type === 'section')
                                    <!-- Department Field -->
                                    <div>
                                        <label for="department_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                            <span class="bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded mr-2">Required</span>
                                            Department
                                        </label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <select name="department_id" id="department_id" class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200 px-4 py-3 border appearance-none group-hover:border-indigo-400">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ $entity->department_id == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
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
                                @endif
                            </div>

                            <!-- Premium form actions -->
                            <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-slate-200 dark:border-slate-600/50">
                                <a href="{{ route('organogram.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-lg text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm hover:shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="group relative inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30">
                                    <span class="mr-4">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </span>
                                    Update {{ ucfirst($type) }}
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
            const divisionSelect = document.getElementById('division_id');
            const departmentSelect = document.getElementById('department_id');

            divisionSelect.addEventListener('change', function() {
                const divisionId = this.value;
                departmentSelect.innerHTML = '<option value="">Select Department</option>';

                if (divisionId) {
                    fetch(`/api/divisions/${divisionId}/departments`)
                        .then(response => response.json())
                        .then(departments => {
                            departments.forEach(dept => {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.name;
                                departmentSelect.appendChild(option);

                                // Preselect the department if it matches the current section's department
                                const currentDepartmentId = "{{ $entity->department_id ?? '' }}";
                                if (dept.id == currentDepartmentId) {
                                    option.selected = true;
                                }
                            });
                        });
                }
            });

            // Trigger change event on page load to populate departments
            divisionSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
