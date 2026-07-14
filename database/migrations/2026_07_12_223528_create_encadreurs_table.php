<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encadreurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('grade')->nullable();
            $table->string('specialite')->nullable();
            $table->string('bureau')->nullable();
            $table->string('telephone')->nullable();
            $table->text('bio')->nullable();
            $table->string('cv_fichier')->nullable();
            $table->string('photo')->nullable();
            $table->integer('max_etudiants')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encadreurs');
    }
};