<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskList extends Model
{
    use HasFactory;

    // Model is named TaskList (not List) because `list` is a reserved word in PHP.
    protected $table = 'lists';

    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * SRS-02 & SRS-09: Relasi ke pemilik (owner) list.
     * Pengguna pembuat list otomatis menjadi owner melalui foreign key user_id.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'list_id');
    }

    // SRS-07: progress percentage (used by teammate's monitoring feature too)
    public function progressPercentage(): int
    {
        $total = $this->tasks()->count();
        if ($total === 0) {
            return 0;
        }

        $done = $this->tasks()->where('is_completed', true)->count();

        return (int) round(($done / $total) * 100);
    }
}
