@extends('layouts.app')

@section('title', 'Edit User Name')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Edit User Name</h1>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-600">
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-4 text-sm text-green-600 dark:text-green-400">
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
                    <div class="flex justify-center">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-md shadow-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                            Update Name
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
