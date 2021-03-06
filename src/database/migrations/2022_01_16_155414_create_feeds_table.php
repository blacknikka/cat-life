<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();

            $table->time('served_at');
            $table->float('amount');
            $table->text('memo')->nullable()->default(null);

            // user ID
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // food ID
            $table->bigInteger('food_id')->unsigned()->nullable()->default(null);;
            $table->foreign('food_id')->references('id')->on('food_catalogs')->onDelete('cascade');

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
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropForeign('feeds_user_id_foreign');
        });
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropForeign('feeds_food_id_foreign');
        });
        Schema::dropIfExists('feeds');
    }
}
