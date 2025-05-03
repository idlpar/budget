@section('title', 'Create Transaction')

@section('content')
    <div class="mb-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Transaction</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" value="{{ old('date') }}" required>
                    @error('date')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div id="account-entries">
                    <div class="mb-4 flex items-end space-x-4 account-entry">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                            <select name="account_heads[0][account_head_id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" required>
                                <option value="">Select Account Head</option>
                                @foreach ($accountHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Debit</label>
                            <input type="number" name="account_heads[0][debit]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" value="0" step="0.01" required>
                        </div>
                        <div class="w-32">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credit</label>
                            <input type="number" name="account_heads[0][credit]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" value="0" step="0.01" required>
                        </div>
                        <button type="button" class="remove-entry text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-entry" class="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Account Head</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Transaction</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let entryCount = 1;

            document.getElementById('add-entry').addEventListener('click', () => {
                const container = document.getElementById('account-entries');
                const entry = document.createElement('div');
                entry.className = 'mb-4 flex items-end space-x-4 account-entry';
                entry.innerHTML = `
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Head</label>
                        <select name="account_heads[${entryCount}][account_head_id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" required>
                            <option value="">Select Account Head</option>
                            @foreach ($accountHeads as $accountHead)
                <option value="{{ $accountHead->id }}">{{ $accountHead->name }}</option>
                            @endforeach
                </select>
            </div>
            <div class="w-32">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Debit</label>
                <input type="number" name="account_heads[${entryCount}][debit]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" value="0" step="0.01" required>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credit</label>
                        <input type="number" name="account_heads[${entryCount}][credit]" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200" value="0" step="0.01" required>
                    </div>
                    <button type="button" class="remove-entry text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Remove</button>
                `;
                container.appendChild(entry);
                entryCount++;

                updateRemoveButtons();
            });

            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-entry')) {
                    e.target.parentElement.remove();
                    entryCount--;
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                const entries = document.querySelectorAll('.account-entry');
                entries.forEach((entry, index) => {
                    const removeButton = entry.querySelector('.remove-entry');
                    removeButton.style.display = entries.length > 2 ? 'block' : 'none';
                });
            }

            updateRemoveButtons();
        </script>
    @endpush
@endsection
