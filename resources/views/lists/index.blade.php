<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">List Saya</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-lg font-semibold">Semua List/Project</h1>
            <a href="{{ route('lists.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + List Baru
            </a>
        </div>

        <div class="grid gap-4">
            @forelse ($lists as $list)
                <a href="{{ route('lists.show', $list) }}" class="block p-4 bg-white shadow rounded hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $list->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $list->tasks_count }} tugas</p>
                        </div>
                        <span class="text-gray-400 text-sm">Lihat &rarr;</span>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">Belum ada list. Yuk bikin yang pertama.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
