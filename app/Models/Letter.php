<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'letter_type_id',
        'number', // nomor surat jika sudah terbit
        'ticket_number', // nomor tiket request
        'subject',
        'recipient',
        'recipient_address',
        'letter_date',
        'expired_date',
        'status',
        'note',
        'file_path',
        'json_content',
    ];

    // cast
    protected $casts = [
        'letter_date' => 'date',
        'expired_date' => 'date',
        'json_content' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }
}
