<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plat_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plat_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantite', 8, 2);
            $table->string('unite', 10);
            $table->timestamps();
            
            $table->unique(['plat_id', 'ingredient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('plat_ingredient');
    }
};