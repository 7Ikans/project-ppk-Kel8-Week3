<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class TaskController extends Controller
{
    public function create(TaskList $list): View
    {
        $this->authorizeOwner($list);

        return view('tasks.create', compact('list'));
    }

    // NFR-01: perubahan data dibungkus DB::transaction — sukses -> commit
    // otomatis, gagal/exception -> rollback otomatis, ga ada data setengah jadi.
    public function store(Request $request, TaskList $list): RedirectResponse
    {
        $this->authorizeOwner($list);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        try {
            DB::transaction(function () use ($list, $validated) {
                $list->tasks()->create($validated);
            });
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menambah tugas, silakan coba lagi.');
        }

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

        try {
            DB::transaction(function () use ($task, $validated) {
                $task->update($validated);
            });
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Gagal mengupdate tugas, silakan coba lagi.');
        }

        return redirect()->route('lists.show', $list)->with('status', 'Tugas berhasil diupdate.');
    }

    // SRS-05: toggle completion status
    public function toggle(TaskList $list, Task $task): RedirectResponse
    {
        $this->authorizeOwner($list);

        try {
            DB::transaction(function () use ($task) {
                $task->update(['is_completed' => ! $task->is_completed]);
            });
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal mengubah status tugas, silakan coba lagi.');
        }

        return back()->with('status', $task->is_completed ? 'Tugas ditandai selesai.' : 'Tugas ditandai belum selesai.');
    }

    public function destroy(TaskList $list, Task $task): RedirectResponse
    {
        $this->authorizeOwner($list);

        try {
            DB::transaction(function () use ($task) {
                $task->delete();
            });
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal menghapus tugas, silakan coba lagi.');
        }

        return redirect()->route('lists.show', $list)->with('status', 'Tugas berhasil dihapus.');
    }

    private function authorizeOwner(TaskList $list): void
    {
        abort_unless($list->user_id === auth()->id(), 403);
    }
}