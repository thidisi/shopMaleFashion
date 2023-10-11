<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug');
            $table->text('image');
            $table->foreignId('major_category_id')->constrained();
            $table->enum('sort_order', [
                'slider',
                'instagram',
                'banner',
                'hide',
            ])->default(App\Models\Slide::SLIDE_ORDER['SLIDER']);
            $table->enum('status', [
                'active',
                'inactive',
            ])->default(App\Models\Slide::SLIDE_STATUS['ACTIVE']);
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
        Schema::dropIfExists('slide');
    }
}
