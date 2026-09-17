<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * SRS-06: Kolaborasi List
 * Mengelola penambahan dan penghapusan member dalam suatu list.
 * Hanya owner list yang boleh menambah/menghapus member.
 */
class ListMemberController extends Controller
{
    /**
     * Tampilkan halaman kelola member untuk list tertentu.
     * Hanya owner yang boleh mengakses.
     */
    public function index(TodoList $list)
    {
        // Pastikan hanya owner yang bisa kelola member
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat mengelola member.');
        }

        // Ambil semua member saat ini
        $members = $list->members;

        // Ambil semua user yang belum jadi member dan bukan owner
        $availableUsers = User::where('id', '!=', $list->user_id)
            ->whereNotIn('id', $members->pluck('id'))
            ->get();

        return view('lists.members.index', compact('list', 'members', 'availableUsers'));
    }

    /**
     * SRS-06: Tambahkan user sebagai member ke dalam list.
     */
    public function store(Request $request, TodoList $list)
    {
        // Pastikan hanya owner yang bisa tambah member
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat menambahkan member.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;

        // Jangan tambahkan owner itu sendiri sebagai member
        if ($userId == $list->user_id) {
            return back()->with('error', 'Anda tidak bisa menambahkan diri sendiri sebagai member.');
        }

        // Cegah duplikat (sudah ada unique constraint di DB, ini untuk pesan error yang baik)
        if ($list->members()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'User tersebut sudah menjadi member list ini.');
        }

        $list->members()->attach($userId);

        return back()->with('success', 'Member berhasil ditambahkan.');
    }

    /**
     * SRS-06: Hapus user dari member list.
     */
    public function destroy(TodoList $list, User $user)
    {
        // Pastikan hanya owner yang bisa hapus member
        if (Auth::id() !== $list->user_id) {
            abort(403, 'Hanya pemilik list yang dapat menghapus member.');
        }

        $list->members()->detach($user->id);

        return back()->with('success', 'Member berhasil dihapus dari list.');
    }
}
