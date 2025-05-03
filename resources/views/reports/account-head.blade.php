@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Expense Details for {{ $accountHead->name }}</h2>

                    <form method="GET" action="{{ route('reports.account-head', $accountHead) }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Period</label>
                                <select name="period" id="period" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                                    <option value="day" {{ $period === 'day' ? 'selected' : '' }}>Day</option>
                                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Week</option>
                                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Month</option>
                                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Year</option>
                                    <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-100">
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate</button>
                        <button type="button" onclick="window.print()" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Print</button>
                    </form>

                    @if($entries->isNotEmpty())
                        <div class="overflow-x-auto print:overflow-visible">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount (BDT)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($entries as $entry)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $entry->transaction->transaction_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($entry->debit, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $entry->transaction->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-gray-100">
                                        Total: {{ $total }} BDT
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-300">No expenses found for the selected criteria.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
            table { width: 100%; }
        }
    </style>
@endsection
