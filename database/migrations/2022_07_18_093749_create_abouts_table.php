<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('phone_second')->nullable();
            $table->string('email');
            $table->string('logo');
            $table->string('address');
            $table->string('address_second')->nullable();
            $table->string('address_third')->nullable();
            $table->string('link_address_fb')->nullable();
            $table->string('link_address_youtube')->nullable();
            $table->string('link_address_zalo')->nullable();
            $table->string('link_address_instagram')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
}
