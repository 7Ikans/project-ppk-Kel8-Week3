<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JARA - {{ $title ?? 'Todo List' }}</title>
    {{-- SEMENTARA: Tailwind lewat CDN, ga perlu npm install/build.
         Ganti ke Vite+Tailwind proper kalau tim udah sepakat setup akhirnya kayak apa. --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('lists.index') }}" class="font-bold text-indigo-600">JARA</a>
            <div class="text-sm text-gray-500">
                {{ auth()->check() ? auth()->user()->name : 'Guest' }}
            </div>
        </div>
    </nav>

    <header class="bg-white border-b">
        <div class="max-w-4xl mx-auto px-4 py-4">
            {{ $header ?? '' }}
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
