@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="max-w-md mx-auto bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-6 text-center">Edit Profile</h2>
        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('name')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @error('email')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Avatar</label>
                <input id="avatar" type="file" name="avatar" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-slate-200" />
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="mt-2 h-20 w-20 rounded-full">
                @endif
                @error('avatar')
                <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transition-all duration-200">Update Profile</button>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
