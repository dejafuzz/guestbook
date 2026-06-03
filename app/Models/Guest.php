<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guest extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'nama_utama',
        'nomor_undangan',
        'jumlah_tamu',
        'qr_code',
        'status',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function checkIn(): HasOne
    {
        return $this->hasOne(CheckIn::class);
    }

    public function souvenirClaim(): HasOne
    {
        return $this->hasOne(SouvenirClaim::class);
    }

    public function sudahCheckIn(): bool
    {
        return $this->status !== 'terdaftar';
    }

    public function sudahAmbilSouvenir(): bool
    {
        return $this->status === 'souvenir_diambil';
    }

}