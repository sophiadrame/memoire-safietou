<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soutenances', function (Blueprint $table) {
            $table->id();
            $table->string('titre_memoire');
            $table->string('etudiant_nom');
            $table->string('etudiant_prenom');
            $table->string('filiere');
            $table->date('date_soutenance');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('salle');
            $table->string('statut')->default('planifiée');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soutenances');
    }
};