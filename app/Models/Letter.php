<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Letter extends Model implements HasMedia
{
    use HasUuids, SoftDeletes, InteractsWithMedia;

    const MEDIA_COLLECTION = 'letters';

    protected $fillable = [
        'ticket_id', // nomor tiket request
        'number', // nomor surat jika sudah terbit
        'letter_date',
        'expired_date',
        'json_content',
    ];

    // cast
    protected $casts = [
        'letter_date' => 'date',
        'expired_date' => 'date',
        'json_content' => 'array',
    ];

    /**
     * Get the ticket that owns the Letter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
