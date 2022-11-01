<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_comments', function (Blueprint $table) {
            $table->foreignId('comment_id')->constrained();
            $table->foreignId('production_id')->constrained();
            $table->primary(['comment_id', 'production_id']);
            $table->integer('review')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_comments');
    }
}
