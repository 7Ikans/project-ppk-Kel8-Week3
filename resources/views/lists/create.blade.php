<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat List Baru</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        <form method="POST" action="{{ route('lists.store') }}" class="bg-white shadow rounded p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama List</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded border-gray-300">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                <a href="{{ route('lists.index') }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
