@extends('layouts.app')

@section('title', 'Account Head Details')

@section('content')
    <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl p-8 max-w-3xl mx-auto space-y-8">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">🧾 Account Head Details</h1>
            <a href="{{ route('accounts.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-slate-600 rounded-md hover:bg-slate-700 dark:bg-slate-500 dark:hover:bg-slate-400 transition">
                ← Back
            </a>
        </div>

        {{-- Account Info --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Account Code</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ $accountHead->account_code }}</div>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Name</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ $accountHead->name }}</div>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Type</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ $accountHead->type }}</div>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Created By</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ $accountHead->creator?->name ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Updated By</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ $accountHead->updater?->name ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-600 dark:text-slate-300 mb-1">Created At</label>
                <div class="text-sm text-slate-900 dark:text-slate-100">{{ \Carbon\Carbon::parse($accountHead->created_at)->format('d-m-y g:i A') }}</div>
            </div>
        </div>

        {{-- Change History --}}
        <div>
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">🕒 Change History</h2>
            @if ($accountHead->changes->isEmpty())
                <p class="text-sm text-slate-600 dark:text-slate-400 italic">No changes recorded.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-600">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                        <thead class="bg-slate-100 dark:bg-slate-700">
                        <tr>
                            @foreach (['Field', 'Old Value', 'New Value', 'Changed By', 'Changed At'] as $col)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-600">
                        @foreach ($accountHead->changes as $change)
                            <tr>
                                <td class="px-4 py-2 text-sm text-slate-800 dark:text-slate-200">{{ ucfirst($change->field_name) }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-300">{{ $change->old_value }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-300">{{ $change->new_value }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-300">{{ $change->changer?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($change->changed_at)->format('d-m-y g:i A') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Edit Button --}}
        <div class="flex justify-end pt-4 border-t dark:border-slate-600">
            <a href="{{ route('accounts.edit', $accountHead) }}"
               class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-500 transition">
                ✏️ Edit Account Head
            </a>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
