<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'nama_event',
        'slug',
        'template',
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
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Event $event) {
            $event->slug = Str::slug($event->nama_event) . '-' . Str::random(6);
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function invitationContent(): HasOne
    {
        return $this->hasOne(InvitationContent::class);
    }

    public function invitationGalleries(): HasMany
    {
        return $this->hasMany(InvitationGallery::class)->orderBy('order');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}