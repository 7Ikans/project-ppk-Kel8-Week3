<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Support\Facades\Auth;

/**
 * SRS-07: Monitoring Progress
 * Menampilkan perkembangan penyelesaian tugas dalam suatu list.
 */
class ListProgressController extends Controller
{
    /**
     * Tampilkan progress penyelesaian tugas dalam list.
     * Bisa diakses oleh owner maupun member list.
     */
    public function show(TodoList $list)
    {
        $userId = Auth::id();

        // Cek apakah user adalah owner atau member list ini
        $isOwner  = $list->user_id === $userId;
        $isMember = $list->members()->where('user_id', $userId)->exists();

        if (!$isOwner && !$isMember) {
            abort(403, 'Anda tidak memiliki akses ke list ini.');
        }

        $totalTasks     = $list->tasks()->count();
        $completedTasks = $list->tasks()->where('is_completed', true)->count();
        $pendingTasks   = $totalTasks - $completedTasks;
        $percentage     = $list->progressPercentage();

        return view('lists.progress', compact(
            'list',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'percentage'
        ));
    }
}
