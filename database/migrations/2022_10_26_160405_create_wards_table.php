<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wards', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('district_id');
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('path', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wards');
    }
}
