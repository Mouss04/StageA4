<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orateur extends Model
{
    use HasFactory;

    protected $fillable = ['nom_complet', 'biographie', 'photo'];

    public function sessis()
    {
        return $this->belongsToMany(Sessi::class, 'orateur_sessi');
    }

    // Définir la relation many-to-many avec Communication
    public function communications()
    {
        return $this->belongsToMany(Communication::class, 'communications_orateurs', 'orateur_id', 'communication_id');
    }

    // Relation avec Question
    public function questions()
    {
        return $this->hasMany(Question::class, 'orateur_id'); // Définir hasMany pour les questions liées à cet orateur
    }
}
