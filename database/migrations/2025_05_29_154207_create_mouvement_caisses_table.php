<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mouvement_caisses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('type', ['entree', 'sortie']);
            $table->decimal('montant', 10, 2);
            $table->text('motif')->nullable();
            $table->foreignId('caissier_id')->constrained('users')->onDelete('cascade');
    

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvement_caisses');
    }
};
