<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'model_id',
        'model_type',
        'user_id',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model() // can be question, communication, speaker, sponsor
    {
        return $this->morphTo();
    }

}
