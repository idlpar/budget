@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Reports</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Expense Report</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">View expenses by account head, department, section, division, or transaction.</p>
                            <a href="{{ route('reports.expense') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
