<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'capacite', 'description'];

    // Définir la relation avec Communications
    public function communications()
    {
        return $this->hasMany(Communication::class, 'salle_id');
    }
}
