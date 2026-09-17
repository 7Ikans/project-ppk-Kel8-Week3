<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $list->name }}</h2>
            <a href="{{ route('lists.edit', $list) }}" class="text-sm text-gray-500 hover:underline">Edit list</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        @if ($list->description)
            <p class="text-gray-600 mb-4">{{ $list->description }}</p>
        @endif

        {{-- SRS-07: progress bar --}}
        <div class="mb-6">
            <div class="flex justify-between text-sm text-gray-500 mb-1">
                <span>Progress</span>
                <span>{{ $list->progressPercentage() }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $list->progressPercentage() }}%"></div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="font-medium">Daftar Tugas</h3>
            <a href="{{ route('tasks.create', $list) }}" class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                + Tugas Baru
            </a>
        </div>

        <div class="bg-white shadow rounded divide-y">
            @forelse ($list->tasks as $task)
                <div class="p-4 flex items-center justify-between gap-4 {{ $task->is_completed ? 'opacity-60' : '' }}">
                    <div class="flex items-start gap-3">
                        <form method="POST" action="{{ route('tasks.toggle', [$list, $task]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mt-1 w-5 h-5 rounded-full border-2 {{ $task->is_completed ? 'bg-green-500 border-green-500' : 'border-gray-300' }}"></button>
                        </form>
                        <div>
                            <p class="font-medium {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                {{ $task->title }}
                            </p>
                            @if ($task->description)
                                <p class="text-sm text-gray-500">{{ $task->description }}</p>
                            @endif
                            <div class="flex gap-2 mt-1 text-xs">
                                <span class="px-2 py-0.5 rounded-full
                                    @class([
                                        'bg-red-100 text-red-700' => $task->priority === 'high',
                                        'bg-yellow-100 text-yellow-700' => $task->priority === 'medium',
                                        'bg-gray-100 text-gray-600' => $task->priority === 'low',
                                    ])">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                @if ($task->due_date)
                                    <span class="text-gray-400">Deadline: {{ $task->due_date->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 text-sm">
                        <a href="{{ route('tasks.edit', [$list, $task]) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', [$list, $task]) }}" onsubmit="return confirm('Hapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-4 text-gray-500">Belum ada tugas di list ini.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
