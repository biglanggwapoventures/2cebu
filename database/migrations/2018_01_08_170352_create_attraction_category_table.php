<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttractionCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attraction_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attraction_id');
            $table->unsignedInteger('category_id');
            $table->timestamps();
            $table->foreign('attraction_id')->references('id')->on('attractions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('attraction_categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attraction_category');
    }
}
