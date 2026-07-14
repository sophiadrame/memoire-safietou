<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'titre_memoire',
        'etudiant_nom',
        'etudiant_prenom',
        'filiere',
        'date_soutenance',
        'heure_debut',
        'heure_fin',
        'salle',
        'statut',
    ];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function juries()
    {
        return $this->hasMany(Jury::class);
    }

    public function procesVerbal()
    {
        return $this->hasOne(ProcesVerbal::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}