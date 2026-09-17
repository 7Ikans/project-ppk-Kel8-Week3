<x-app-layouts>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('lists.show', $list) }}" class="text-sm text-indigo-600 hover:underline inline-flex items-center gap-1 mb-1">
                    &larr; Kembali ke List
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Monitoring Progress: {{ $list->name }}
                </h2>
            </div>
            <a href="{{ route('lists.show', $list) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded hover:bg-gray-200">
                Lihat Detail Tugas
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 space-y-6">
        @if ($list->description)
            <p class="text-gray-600">{{ $list->description }}</p>
        @endif

        {{-- Kartu Utama Ringkasan Progress --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold text-gray-800 text-lg mb-4">Progres Penyelesaian Tugas</h3>

            @if ($totalTasks === 0)
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-2">Belum ada tugas dalam list ini.</p>
                    <a href="{{ route('tasks.create', $list) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                        + Tambah Tugas Pertama
                    </a>
                </div>
            @else
                {{-- Persentase & Status Badge --}}
                <div class="text-center mb-6">
                    <div class="text-5xl font-extrabold text-indigo-600 mb-2">
                        {{ $percentage }}%
                    </div>
                    <p class="text-gray-600 text-sm">
                        <strong>{{ $completedTasks }}</strong> dari <strong>{{ $totalTasks }}</strong> tugas telah diselesaikan
                    </p>

                    <div class="mt-3">
                        @if ($percentage === 100)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                &#10003; Semua Tugas Selesai
                            </span>
                        @elseif ($percentage > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Sedang Dikerjakan
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Belum Ada yang Selesai
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Progress Bar Dinamis --}}
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden mb-6">
                    <div class="bg-indigo-600 h-4 rounded-full transition-all duration-500 ease-out" style="width: {{ $percentage }}%"></div>
                </div>

                {{-- Grid Statistik --}}
                <div class="grid grid-cols-3 gap-4 border-t pt-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <span class="block text-2xl font-bold text-gray-800">{{ $totalTasks }}</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Total Tugas</span>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <span class="block text-2xl font-bold text-green-600">{{ $completedTasks }}</span>
                        <span class="text-xs text-green-700 uppercase tracking-wide">Selesai</span>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-lg">
                        <span class="block text-2xl font-bold text-amber-600">{{ $pendingTasks }}</span>
                        <span class="text-xs text-amber-700 uppercase tracking-wide">Belum Selesai</span>
                    </div>
                </div>
            @endif
        </div>

        @if ($totalTasks > 0)
            {{-- Rincian Tugas yang Masih Perlu Diselesaikan --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 flex items-center justify-between">
                    <span>Tugas Belum Selesai ({{ $pendingTasks }})</span>
                </h3>

                @if ($pendingTaskList->isEmpty())
                    <p class="text-sm text-green-600">Hebat! Tidak ada tugas yang tertunda.</p>
                @else
                    <div class="divide-y">
                        @foreach ($pendingTaskList as $task)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium text-sm">{{ $task->title }}</p>
                                    @if ($task->due_date)
                                        <p class="text-xs text-gray-400">Deadline: {{ $task->due_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    @if($task->priority === 'high') bg-red-100 text-red-700
                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Rincian Tugas yang Sudah Selesai --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4">
                    Tugas Selesai ({{ $completedTasks }})
                </h3>

                @if ($completedTaskList->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada tugas yang selesai.</p>
                @else
                    <div class="divide-y">
                        @foreach ($completedTaskList as $task)
                            <div class="py-3 flex items-center justify-between opacity-75">
                                <div>
                                    <p class="text-gray-700 line-through text-sm">{{ $task->title }}</p>
                                    @if ($task->due_date)
                                        <p class="text-xs text-gray-400">Selesai • Deadline: {{ $task->due_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                                <span class="text-xs text-green-600 font-medium">&#10003; Selesai</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layouts>
