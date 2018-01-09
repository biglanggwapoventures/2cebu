<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attraction_id');
            $table->string('description');
            $table->text('remarks');
            $table->decimal('min_rate', 13, 2);
            $table->decimal('max_rate', 13, 2);
            $table->timestamps();

            $table->foreign('attraction_id')->references('id')->on('attractions')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accomodations');
    }
}
