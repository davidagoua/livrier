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
        Schema::create('itineraies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('origine_id');
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('prix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itineraies');
    }
};
