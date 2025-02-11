<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'nom', 'description', 'logo', 'fichier', 'category'
    ];

    // App\Models\Sponsor.php

public function fichiers()
{
    return $this->hasMany(Fichier::class, 'sponsors_id');
}

}
