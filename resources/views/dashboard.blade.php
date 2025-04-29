@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white dark:bg-slate-700 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-4">Dashboard</h2>
        <p class="text-slate-600 dark:text-slate-400">Welcome, {{ auth()->user()->name }}! Manage your budgets, approvals, and reports from here.</p>
    </div>
@endsection
