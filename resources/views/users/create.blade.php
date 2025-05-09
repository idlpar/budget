@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
    <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Create New User</h2>
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('name')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('email')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                <input id="password" type="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('password')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Role</label>
                <select id="role" name="role" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200">
                    <option value="" disabled selected>Select a role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Create User</button>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
