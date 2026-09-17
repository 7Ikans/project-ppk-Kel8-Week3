<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListController extends Controller
{
    public function index(): View
    {
        // Own lists only (SRS-02). Collaborator lists (SRS-06) can be merged in later
        // once the collaboration table from that teammate's feature exists.
        $lists = TaskList::where('user_id', auth()->id())
            ->withCount('tasks')
            ->latest()
            ->get();

        return view('lists.index', compact('lists'));
    }

    public function create(): View
    {
        return view('lists.create');
    }

    /**
     * SRS-02: Membuat list baru
     * SRS-09: Kepemilikan List Otomatis — Pengguna yang membuat daftar tugas baru
     * secara otomatis menjadi pemilik (owner) dengan menetapkan user_id dari user yang sedang login (auth()->id()).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $list = TaskList::create([
            ...$validated,
            'user_id' => auth()->id(), // SRS-09: Otomatis menetapkan pembuat sebagai owner
        ]);

        return redirect()->route('lists.show', $list)->with('status', 'List berhasil dibuat.');
    }


    public function show(TaskList $list): View
    {
        $this->authorizeOwner($list);

        $list->load(['tasks' => fn ($q) => $q->orderBy('due_date')]);

        return view('lists.show', compact('list'));
    }

    public function edit(TaskList $list): View
    {
        $this->authorizeOwner($list);

        return view('lists.edit', compact('list'));
    }

    public function update(Request $request, TaskList $list): RedirectResponse
    {
        $this->authorizeOwner($list);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $list->update($validated);

        return redirect()->route('lists.show', $list)->with('status', 'List berhasil diupdate.');
    }

    public function destroy(TaskList $list): RedirectResponse
    {
        $this->authorizeOwner($list);

        $list->delete();

        return redirect()->route('lists.index')->with('status', 'List berhasil dihapus.');
    }

    // Simple ownership guard. Swap for a proper Policy once auth (SRS-01) is finalized.
    private function authorizeOwner(TaskList $list): void
    {
        abort_unless($list->user_id === auth()->id(), 403);
    }
}
