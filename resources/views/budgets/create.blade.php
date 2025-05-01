@extends('layouts.app')

@section('content')
    <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Create Budget</h1>
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="account_head_id" class="block text-sm font-medium">Account Head</label>
                <select name="account_head_id" id="account_head_id" class="border p-2 w-full">
                    @foreach($accountHeads as $head)
                        <option value="{{ $head->id }}">{{ $head->name }} ({{ $head->account_code }})</option>
                    @endforeach
                </select>
                @error('account_head_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="financial_year" class="block text-sm font-medium">Financial Year</label>
                <input type="text" name="financial_year" id="financial_year" value="{{ old('financial_year') }}" class="border p-2 w-full" placeholder="e.g., 2023-2024">
                @error('financial_year') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="department_id" class="block text-sm font-medium">Department</label>
                <select name="department_id" id="department_id" class="border p-2 w-full" onchange="fetchSections(this.value)">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="section_id" class="block text-sm font-medium">Section</label>
                <select name="section_id" id="section_id" class="border p-2 w-full">
                    <option value="">Select Section</option>
                </select>
                @error('section_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium">Estimated Amount</label>
                <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount') }}" class="border p-2 w-full">
                @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>

    <script>
        async function fetchSections(departmentId) {
            if (!departmentId) return;
            const response = await fetch(`/api/sections?department_id=${departmentId}`);
            const sections = await response.json();
            const sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            sections.forEach(section => {
                sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
            });
        }
    </script>
@endsection
