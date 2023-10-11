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
            $table->string('title', 100);
            $table->string('phone', 15);
            $table->string('phone_second', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->string('logo', 255);
            $table->text('branch')->nullable();
            $table->text('branch_second')->nullable();
            $table->text('address');
            $table->text('address_second')->nullable();
            $table->text('address_third')->nullable();
            $table->string('link_address_fb', 255)->nullable();
            $table->string('link_address_youtube', 255)->nullable();
            $table->string('link_address_zalo', 255)->nullable();
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
