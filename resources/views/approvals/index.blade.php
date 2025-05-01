@extends('layouts.app')

@section('title', 'Approvals')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Approvals</h1>
            <a href="{{ route('approvals.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Create Approval</a>
        </div>
        @if (session('success'))
            <div class="px-4 py-3 text-sm text-green-600 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif
        <div class="border-t border-slate-200 dark:border-slate-600">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Details</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Created By</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-700 divide-y divide-slate-200 dark:divide-slate-600">
                @foreach ($approvals as $approval)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ $approval->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $approval->details }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $approval->user->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
