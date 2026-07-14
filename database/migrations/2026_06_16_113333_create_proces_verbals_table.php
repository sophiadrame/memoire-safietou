<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proces_verbals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soutenance_id')->constrained('soutenances')->onDelete('cascade');
            $table->decimal('note', 4, 2)->nullable();
            $table->string('mention')->nullable();
            $table->text('appreciation')->nullable();
            $table->string('decision')->default('Admis');
            $table->date('date_pv');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proces_verbals');
    }
};