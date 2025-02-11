<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les rôles définis dans l'application.
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_ORATEUR = 'orateur';
    const ROLE_SPONSOR = 'sponsor';
    const ROLE_VISITEUR = 'visiteur';

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_complet',
        'surnom',
        'email',
        'motdepasse',
        'photo',
        'role', // Permet d'assigner un rôle
    ];

    /**
     * Les attributs cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'motdepasse',
        'remember_token',
    ];

    /**
     * Obtenir le mot de passe pour l'authentification.
     */
    public function getAuthPassword()
    {
        return $this->motdepasse; // Indique à Laravel que le champ du mot de passe est `motdepasse`
    }

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Vérifie si l'utilisateur a un rôle spécifique.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return strtolower(trim($this->role)) === strtolower(trim($role));
    }

    /**
     * Vérifie si l'utilisateur est admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * Vérifie si l'utilisateur est orateur.
     */
    public function isOrateur(): bool
    {
        return $this->hasRole(self::ROLE_ORATEUR);
    }

    /**
     * Vérifie si l'utilisateur est sponsor.
     */
    public function isSponsor(): bool
    {
        return $this->hasRole(self::ROLE_SPONSOR);
    }

    /**
     * Vérifie si l'utilisateur est visiteur.
     */
    public function isVisiteur(): bool
    {
        return $this->hasRole(self::ROLE_VISITEUR);
    }
}
