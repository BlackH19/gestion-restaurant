<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisponibleToPlatsTable extends Migration
{
    public function up()
    {
       Schema::table('plats', function (Blueprint $table) {
    $table->boolean('disponible')->default(true); // Pas de after('prix')
    });

    }

    public function down()
    {
        Schema::table('plats', function (Blueprint $table) {
            $table->dropColumn('disponible');
        });
    }
}