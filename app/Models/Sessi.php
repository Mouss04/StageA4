<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Communication;

class Sessi extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'date', 'heure_debut', 'heure_fin'];

    // Relation avec les orateurs
    public function orateurs()
    {
        return $this->belongsToMany(Orateur::class, 'orateur_sessi');
    }

    // Relation avec les communications
    public function communications()
    {
        // Changer 'session_id' en 'sessis_id' dans la relation
        return $this->hasMany(Communication::class, 'sessis_id');
    }
}
