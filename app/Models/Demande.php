<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'sujet_id',
        'encadreur_id',
        'statut',
        'message_etudiant',
        'message_encadreur',
        'memoire_fichier',
        'date_depot',
    ];

    protected $casts = [
        'date_depot' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function sujet()
    {
        return $this->belongsTo(Sujet::class);
    }

    public function encadreur()
    {
        return $this->belongsTo(User::class, 'encadreur_id');
    }

    public function isEnAttente(): bool   { return $this->statut === 'en_attente'; }
    public function isAcceptee(): bool    { return $this->statut === 'acceptee'; }
    public function isRefusee(): bool     { return $this->statut === 'refusee'; }
    public function isMemoireDepose(): bool { return $this->statut === 'memoire_depose'; }
    public function isMemoireValide(): bool { return $this->statut === 'memoire_valide'; }
}