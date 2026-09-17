<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tugas Baru — {{ $list->name }}</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        <form method="POST" action="{{ route('tasks.store', $list) }}" class="bg-white shadow rounded p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded border-gray-300">
                @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                    <select name="priority" class="mt-1 block w-full rounded border-gray-300">
                        <option value="low" @selected(old('priority') === 'low')>Low</option>
                        <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                        <option value="high" @selected(old('priority') === 'high')>High</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deadline (opsional)</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                <a href="{{ route('lists.show', $list) }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
