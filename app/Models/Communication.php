<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'type',
        'program_session_id',
        'room_id',
    ];

    /**
     * Get the program session associated with the communication.
     */
    public function programSession()
    {
        return $this->belongsTo(ProgramSession::class, 'program_session_id');
    }

    /**
     * Get the room associated with the communication.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the speakers associated with the communication.
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'communication_speaker', 'communication_id', 'speaker_id');
    }

    /**
     * Get the questions related to the communication.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'communication_id');
    }

    /**
     * Get the sponsors associated with the communication.
     */
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'communication_sponsor', 'communication_id', 'sponsor_id');
    }
}
