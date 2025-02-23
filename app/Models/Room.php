<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'capacity',
        'description',
    ];

    /**
     * Get the communications assigned to this room.
     */
    public function communications()
    {
        return $this->hasMany(Communication::class, 'room_id');
    }
}
