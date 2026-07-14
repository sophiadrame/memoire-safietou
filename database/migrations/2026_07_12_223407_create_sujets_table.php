<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sujets', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('filiere');
            $table->string('niveau');
            $table->enum('type', ['PFE', 'Mémoire', 'Thèse'])->default('Mémoire');
            $table->foreignId('encadreur_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', ['disponible', 'pris', 'archivé'])->default('disponible');
            $table->string('mots_cles')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sujets');
    }
};