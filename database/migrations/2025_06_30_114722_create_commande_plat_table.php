<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commande_plat', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('commande_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->foreignId('plat_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->unsignedInteger('quantite')->default(1);
            $table->timestamps();
            
            // Index composite pour éviter les doublons
            $table->unique(['commande_id', 'plat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_plat');
    }
};