<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SouvenirClaim extends Model
{
    use HasUuids;

    protected $fillable = [
        'guest_id',
        'jumlah_diambil',
        'metode',
        'waktu_claim',
        'dicatat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'waktu_claim' => 'datetime'
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}