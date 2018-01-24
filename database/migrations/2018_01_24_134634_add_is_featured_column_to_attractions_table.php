<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedColumnToAttractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attractions', function (Blueprint $table) {
            $table->boolean('is_featured')->default(0)->after('status_remarks');
            $table->text('feature_banner')->nullable()->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attractions', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'feature_banner']);
        });
    }
}
