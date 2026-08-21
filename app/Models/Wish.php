<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wish extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'event_id',
        'nama',
        'pesan',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

}