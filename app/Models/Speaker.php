<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Speaker extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'biography',
    ];

    /**
     * Get the communications associated with the speaker.
     */
    public function communications()
    {
        return $this->belongsToMany(Communication::class, 'communication_speaker', 'speaker_id', 'communication_id');
    }

    /**
     * Get the questions asked to the speaker.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'speaker_id');
    }

    /**
     * Get the speaker's avatar.
     */
    public function avatar()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'photo');
    }
}
