<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sujet_id')->constrained('sujets')->onDelete('cascade');
            $table->foreignId('encadreur_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', [
                'en_attente',
                'acceptee',
                'refusee',
                'memoire_depose',
                'memoire_valide',
                'memoire_refuse'
            ])->default('en_attente');
            $table->text('message_etudiant')->nullable();
            $table->text('message_encadreur')->nullable();
            $table->string('memoire_fichier')->nullable();
            $table->timestamp('date_depot')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};