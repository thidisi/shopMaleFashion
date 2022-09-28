<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionAttributeValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_attr_value', function (Blueprint $table) {
            $table->foreignId('production_id')->constrained();
            $table->foreignId('attribute_value_id')->constrained();
            $table->primary(array('production_id', 'attribute_value_id'));
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
        Schema::dropIfExists('production_attr_value');
    }
}
