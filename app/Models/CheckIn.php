<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    use HasUuids;

    protected $fillable = [
        'guest_id',
        'jumlah_hadir',
        'metode',
        'waktu_checkin',
        'dicatat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'waktu_checkin' => 'datetime'
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}