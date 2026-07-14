<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encadreur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grade',
        'specialite',
        'bureau',
        'telephone',
        'bio',
        'cv_fichier',
        'photo',
        'max_etudiants',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nbEtudiantsActuels(): int
    {
        return Demande::where('encadreur_id', $this->user_id)
            ->whereIn('statut', ['acceptee', 'memoire_depose', 'memoire_valide'])
            ->count();
    }

    public function placesDisponibles(): int
    {
        return $this->max_etudiants - $this->nbEtudiantsActuels();
    }

    public function estComplet(): bool
    {
        return $this->nbEtudiantsActuels() >= $this->max_etudiants;
    }
}