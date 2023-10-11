<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->string('username', 200);
            $table->string('password', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 15)->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->text('avatar', 255)->nullable();
            $table->enum('gender', [
                'male',
                'female',
            ]);
            $table->enum('level', [
                'staff',
                'manager',
                'admin',
            ])->default(App\Models\User::USER_LEVEL['STAFF']);
            $table->enum('status', [
                'active',
                'inactive',
                'pending',
            ])->default(App\Models\User::USER_STATUS['PENDING']);
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
