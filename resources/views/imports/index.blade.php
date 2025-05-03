@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Import Data</h2>

                    <form method="POST" action="{{ route('imports.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Import Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                <option value="organogram">Organogram</option>
                            </select>
                            @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Excel File</label>
                            <input type="file" name="file" id="file" accept=".xlsx,.xls" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                            @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
