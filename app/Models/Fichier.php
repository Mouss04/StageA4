<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Fichier extends Model
{
    use HasFactory;

    // Définir la table associée (facultatif si le nom suit la convention plurielle)
    protected $table = 'fichiers';

    // Indiquer les colonnes qui sont modifiables
    protected $fillable = [
        'sponsors_id', // Clé étrangère vers la table sponsors
        'fichier',     // Nom du fichier
    ];

    // Définir la relation avec la table Sponsor (chaque fichier appartient à un sponsor)
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsors_id');
    }

    /**
     * Méthode pour supprimer le fichier physique lorsque le modèle est supprimé
     */
    public static function boot()
    {
        parent::boot();

        // Supprimer le fichier physique du stockage lorsqu'un enregistrement est supprimé
        static::deleting(function ($fichier) {
            // Vérifier si le fichier existe dans le stockage avant de tenter de le supprimer
            if (Storage::exists('public/' . $fichier->fichier)) {
                Storage::delete('public/' . $fichier->fichier);
            }
        });
    }

    /**
     * Accessor pour obtenir l'URL publique du fichier
     */
    public function getFichierUrlAttribute()
    {
        // Retourne l'URL accessible publiquement du fichier
        return Storage::url($this->fichier);
    }
}
