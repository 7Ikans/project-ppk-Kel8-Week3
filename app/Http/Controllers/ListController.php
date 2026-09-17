<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ListController extends Controller
{
    public function index(): View
    {
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        try {
            $list = DB::transaction(function () use ($validated) {
                return TaskList::create([
                    ...$validated,
                    'user_id' => auth()->id(),
                ]);
            });
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Gagal membuat list, silakan coba lagi.');
        }

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

        try {
            DB::transaction(function () use ($list, $validated) {
                $list->update($validated);
            });
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Gagal mengupdate list, silakan coba lagi.');
        }

        return redirect()->route('lists.show', $list)->with('status', 'List berhasil diupdate.');
    }

    public function destroy(TaskList $list): RedirectResponse
    {
        $this->authorizeOwner($list);

        try {
            DB::transaction(function () use ($list) {
                $list->delete();
            });
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal menghapus list, silakan coba lagi.');
        }

        return redirect()->route('lists.index')->with('status', 'List berhasil dihapus.');
    }

    private function authorizeOwner(TaskList $list): void
    {
        abort_unless($list->user_id === auth()->id(), 403);
    }
}