<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('name', 255);
            $table->float('price');
            $table->integer('quantity');
            $table->string('slug');
            $table->text('descriptions')->nullable();
            $table->integer('count_view')->default(0);
            $table->enum('status', [
                'active',
                'inactive',
            ])->default(App\Models\Production::PRODUCTION_STATUS['ACTIVE']);
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
        Schema::dropIfExists('productions');
    }
}
