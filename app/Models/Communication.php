<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'date',
        'heure_debut',
        'heure_fin',
        'type',
        'sessis_id',
        'salle_id'
    ];

    public function session()
    {
        return $this->belongsTo(Sessi::class, 'sessis_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    // Définir la relation many-to-many avec Orateur
    public function orateurs()
    {
        return $this->belongsToMany(Orateur::class, 'communications_orateurs', 'communication_id', 'orateur_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'communication_id');
    }
}
