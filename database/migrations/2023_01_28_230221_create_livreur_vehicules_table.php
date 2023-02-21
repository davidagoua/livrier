<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livreur_vehicules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('livreur_id');
            $table->unsignedBigInteger('vehicule_id');
            $table->boolean('actif')->default(True);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livreur_vehicules');
    }
};
