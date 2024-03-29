<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->string('slug')->nullable();
            $table->enum('status', [
                'show',
                'hot_default',
                'hide',
            ])->default(App\Models\Major_Category::MENU_STATUS['SHOW']);
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
        Schema::dropIfExists('major_categories');
    }
}
