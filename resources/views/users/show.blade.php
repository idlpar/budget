@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg p-8 max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">User Details</h1>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Back to Users</a>
        </div>
        <div class="grid gap-6">
            <div class="flex items-center gap-4">
                <div>
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-16 w-16 rounded-full">
                    @else
                        <svg class="h-16 w-16 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-200">{{ $user->name }}</h2>
                    <p class="text-slate-600 dark:text-slate-400">{{ $user->email }}</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Created By</label>
                <p class="mt-1 text-sm text-slate-900 dark:text-slate-200">{{ $user->createdBy ? $user->createdBy->name : 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Created At</label>
                <p class="mt-1 text-sm text-slate-900 dark:text-slate-200">{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-y g:i A') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Admin Status</label>
                <p class="mt-1 text-sm text-slate-900 dark:text-slate-200">{{ $user->isAdmin() ? 'Admin' : 'Non-Admin' }}</p>
            </div>
            @if (auth()->user()->isAdmin())
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Name Change History</h3>
                    @if (!$user->previous_name)
                        <p class="text-sm text-slate-600 dark:text-slate-400">No name changes recorded.</p>
                    @else
                        <div class="border-t border-slate-200 dark:border-slate-600">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                                <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Previous Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Changed By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Changed At</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-700 divide-y divide-slate-200 dark:divide-slate-600">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $user->previous_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">{{ $user->nameChangedBy ? $user->nameChangedBy->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-300">{{ $user->name_changed_at ? \Carbon\Carbon::parse($user->name_changed_at)->format('d-m-y g:i A'): 'N/A' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        @if (auth()->user()->isAdmin())
            <div class="mt-6">
                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-500">Edit Name</a>
            </div>
        @endif
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
