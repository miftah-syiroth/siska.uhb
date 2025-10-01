<?php

namespace App\Models;

use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'letter_type_id',
        'number',
        'subject',
        'recipient',
        'recipient_address',
        'status',
        'note',
        'json_content',
    ];

    // accessor
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => TicketStatusEnum::from($this->status)->label(),
        );
    }

    /**
     * Get the user that owns the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the letter type that owns the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class, 'letter_type_id');
    }
}
