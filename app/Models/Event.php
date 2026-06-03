<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'nama_event',
        'tanggal',
        'lokasi',
        'souvenir_mode',
        'receptionist_pin',
        'souvenir_pin',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            // 'receptionist_pin' => 'hashed',
            // 'souvenir_pin' => 'hashed'
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}