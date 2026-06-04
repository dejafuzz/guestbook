<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationContent extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'groom_name',
        'bride_name',
        'groom_photo',
        'bride_photo',
        'hero_photo',
        'love_story',
        'first_met_date',
        'engagement_date',
        'akad_location',
        'akad_address',
        'akad_datetime',
        'akad_maps_url',
        'reception_location',
        'reception_address',
        'reception_datetime',
        'reception_maps_url',
        'opening_quote',
        'closing_quote',
    ];

    protected function casts(): array
    {
        return [
            'first_met_date' => 'date',
            'engagement_date' => 'date',
            'akad_datetime' => 'datetime',
            'reception_datetime' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

}