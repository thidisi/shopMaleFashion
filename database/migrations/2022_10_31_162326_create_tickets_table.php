<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->longText('data_customer');
            $table->float('price');
            $table->string('code',100);
            $table->integer('quantity');
            $table->dateTime('date_end');
            $table->enum('status', [
                'pending',
                'active',
                'suspended',
            ])->default(App\Models\Ticket::TICKET_STATUS['OPEN']);
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
        Schema::dropIfExists('tickets');
    }
}
