<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TodoList extends Model
{
    use HasFactory;

    // Nama tabel karena tidak mengikuti konvensi (TodoList -> todo_lists)
    protected $table = 'lists';

    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * SRS-02: Relasi ke pemilik (owner) list.
     * Setiap list dimiliki oleh satu user.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * SRS-06: Kolaborasi List
     * Relasi Many-to-Many ke users yang menjadi member list (bukan owner).
     * Menggunakan pivot table 'list_user'.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'list_user', 'list_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * SRS-03: Relasi ke semua tugas dalam list ini.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id');
    }

    /**
     * SRS-07: Monitoring Progress
     * Hitung jumlah tugas yang sudah selesai dalam list ini.
     */
    public function completedTasksCount(): int
    {
        return $this->tasks()->where('is_completed', true)->count();
    }

    /**
     * SRS-07: Monitoring Progress
     * Hitung persentase progress penyelesaian tugas (0-100).
     */
    public function progressPercentage(): int
    {
        $total = $this->tasks()->count();

        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->completedTasksCount() / $total) * 100);
    }
}
