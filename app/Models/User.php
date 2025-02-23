<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_title',
        'scanned',
        'full_name',
        'nickname',
        'email',
        'password',
        'institution',
        'address',
        'country',
        'state',
    ];

    /**
     * Hidden attributes for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the user's name.
     */
    public function getNameAttribute()
    {
        return $this->nickname ?: $this->full_name;
    }

    /**
     * Attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's questions.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the user's avatar.
     */
    public function avatar()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'avatar');
    }


    public function programSessions()
    {
        return $this->belongsToMany(ProgramSession::class, 'moderator_program_session','program_session_id','user_id');
    }
}
