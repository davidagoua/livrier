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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('attribution_id')->nullable();
            $table->unsignedBigInteger('itineraie_id');
            $table->unsignedBigInteger('prix')
                ->default(0);
            $table->string('state')->nullable();
            $table->json('description')->nullable();
            $table->json('colis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livraisons');
    }
};
