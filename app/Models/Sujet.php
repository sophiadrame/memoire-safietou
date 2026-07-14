<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'filiere',
        'niveau',
        'type',
        'encadreur_id',
        'statut',
        'mots_cles',
    ];

    public function encadreur()
    {
        return $this->belongsTo(User::class, 'encadreur_id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function isDisponible(): bool
    {
        return $this->statut === 'disponible';
    }

    public function scopeDisponibles($query)
    {
        return $query->where('statut', 'disponible');
    }
}