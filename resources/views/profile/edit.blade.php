@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg max-w-3xl mx-auto p-8 mt-12 relative">
        <!-- Back Button -->
        <a href="{{ route('users.index') }}" class="absolute top-4 right-4 inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out shadow-md">
            <!-- Left Arrow Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-5 w-5 mr-2" fill="currentColor" stroke="currentColor">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
            </svg>
            Back
        </a>


        <h2 class="text-3xl font-semibold text-slate-800 dark:text-slate-200 mb-6 text-center">Edit Profile</h2>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <!-- Form Inputs -->
            <div class="space-y-6">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700" {{ auth()->user()->isAdmin() ? '' : 'disabled' }} />
                    @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700" required />
                    @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Avatar Upload -->
                <div>
                    <label for="avatar" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700" />
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current Avatar" class="mt-4 h-24 w-24 rounded-full mx-auto">
                    @endif
                    @error('avatar')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <x-footer />
@endsection
