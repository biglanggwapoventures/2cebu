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
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->enum('gender', ['male', 'female', 'others'])->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('facebook_uid')->unique()->nullable();
            $table->string('google_uid')->unique()->nullable();
            $table->text('display_photo')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'standard'])->default('standard');
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
