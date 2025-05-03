@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-lg mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg overflow-hidden mt-6">
        <div class="px-6 py-5 sm:px-8 flex justify-between items-center border-b border-slate-200 dark:border-slate-600">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Edit User</h1>
        </div>
        <div class="p-6 sm:p-8">
            @if (session('success'))
                <div class="mb-6 text-sm text-green-600 dark:text-green-400 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700" required />
                    @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Role</label>
                    <select name="role" id="role" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-md shadow-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
