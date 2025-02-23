<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'answer',
        'communication_id',
        'speaker_id',
        'user_id',
        'status',
    ];

    /**
     * Get the user associated with the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the communication associated with the question.
     */
    public function communication()
    {
        return $this->belongsTo(Communication::class, 'communication_id');
    }

    /**
     * Get the speaker who answered the question.
     */
    public function speaker()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }
}
