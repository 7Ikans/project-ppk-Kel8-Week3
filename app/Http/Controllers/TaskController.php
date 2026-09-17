<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(TaskList $list): View
    {
        $this->authorizeOwner($list);

        return view('tasks.create', compact('list'));
    }

    public function store(Request $request, TaskList $list): RedirectResponse
    {
        $this->authorizeOwner($list);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $list->tasks()->create($validated);

        return redirect()->route('lists.show', $list)->with('status', 'Tugas berhasil ditambahkan.');
    }

    public function edit(TaskList $list, Task $task): View
    {
        $this->authorizeOwner($list);

        return view('tasks.edit', compact('list', 'task'));
    }

    public function update(Request $request, TaskList $list, Task $task): RedirectResponse
    {
        $this->authorizeOwner($list);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('lists.show', $list)->with('status', 'Tugas berhasil diupdate.');
    }

    // SRS-05: toggle completion status
    public function toggle(TaskList $list, Task $task): RedirectResponse
    {
        $this->authorizeOwner($list);

        $task->update(['is_completed' => ! $task->is_completed]);

        return back()->with('status', $task->is_completed ? 'Tugas ditandai selesai.' : 'Tugas ditandai belum selesai.');
    }

    public function destroy(TaskList $list, Task $task): RedirectResponse
    {
        $this->authorizeOwner($list);

        $task->delete();

        return redirect()->route('lists.show', $list)->with('status', 'Tugas berhasil dihapus.');
    }

    private function authorizeOwner(TaskList $list): void
    {
        abort_unless($list->user_id === auth()->id(), 403);
    }
}
