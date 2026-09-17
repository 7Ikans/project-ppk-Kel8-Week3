<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit List</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        <form method="POST" action="{{ route('lists.update', $list) }}" class="bg-white shadow rounded p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama List</label>
                <input type="text" name="name" value="{{ old('name', $list->name) }}" class="mt-1 block w-full rounded border-gray-300">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('description', $list->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
                <a href="{{ route('lists.show', $list) }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Batal</a>
            </div>
        </form>

        <form method="POST" action="{{ route('lists.destroy', $list) }}" class="mt-4" onsubmit="return confirm('Yakin hapus list ini beserta semua tugasnya?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 text-sm hover:underline">Hapus list ini</button>
        </form>
    </div>
</x-app-layout>
