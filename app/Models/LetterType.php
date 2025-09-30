<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LetterType extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    const MEDIA_COLLECTION = 'letter-templates';
    
    protected $fillable = [
        'name',
    ];

    // getting the first media url
    public function getTemplateUrl(): ?string
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION);
    }

    // public function letters()
    // {
    //     return $this->hasMany(Letter::class);
    // }
}
