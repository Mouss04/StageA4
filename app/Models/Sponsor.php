<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Sponsor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
    ];

    /**
     * Get the sponsor's communications.
     */
    public function communications()
    {
        return $this->belongsToMany(Communication::class, 'communications_sponsors', 'sponsor_id', 'communication_id');
    }

    /**
     * Get the sponsor's logo.
     */
    public function logo()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }

    /**
     * Get the sponsor's files.
     */
    public function files()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'sponsors');
    }
}
