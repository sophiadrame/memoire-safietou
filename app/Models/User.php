<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isEnseignant(): bool { return $this->role === 'enseignant'; }
    public function isEtudiant(): bool  { return $this->role === 'etudiant'; }

    public function encadreurProfil()
    {
        return $this->hasOne(Encadreur::class);
    }

    public function sujetsProposer()
    {
        return $this->hasMany(Sujet::class, 'encadreur_id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'etudiant_id');
    }

    public function demandesEncadreur()
    {
        return $this->hasMany(Demande::class, 'encadreur_id');
    }

    public function soutenance()
    {
        return $this->hasOne(Soutenance::class, 'etudiant_id');
    }

    public function juries()
    {
        return $this->hasMany(Jury::class, 'user_id');
    }
}