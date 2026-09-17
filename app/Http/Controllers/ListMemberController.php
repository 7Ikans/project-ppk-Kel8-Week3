<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ListMemberController extends Controller
{
    public function index(TodoList $list)
    {
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat mengelola member.');
        }

        $members = $list->members;

        $availableUsers = User::where('id', '!=', $list->user_id)
            ->whereNotIn('id', $members->pluck('id'))
            ->get();

        return view('lists.members.index', compact('list', 'members', 'availableUsers'));
    }

    public function store(Request $request, TodoList $list)
    {
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat menambahkan member.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;

        if ($userId == $list->user_id) {
            return back()->with('error', 'Anda tidak bisa menambahkan diri sendiri sebagai member.');
        }

        if ($list->members()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'User tersebut sudah menjadi member list ini.');
        }

        try {
            DB::transaction(function () use ($list, $userId) {
                $list->members()->attach($userId);
            });
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal menambahkan member, silakan coba lagi.');
        }

        return back()->with('success', 'Member berhasil ditambahkan.');
    }

    public function destroy(TodoList $list, User $user)
    {
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat menghapus member.');
        }

        try {
            DB::transaction(function () use ($list, $user) {
                $list->members()->detach($user->id);
            });
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal menghapus member, silakan coba lagi.');
        }

        return back()->with('success', 'Member berhasil dihapus dari list.');
    }
}