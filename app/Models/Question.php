<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['contenu', 'communication_id', 'orateur_id', 'statut'];

    // Relation avec Communication
    public function communication()
    {
        return $this->belongsTo(Communication::class, 'communication_id');
    }

    // Relation avec Orateur
    public function orateur()
    {
        return $this->belongsTo(Orateur::class, 'orateur_id');
    }
}

