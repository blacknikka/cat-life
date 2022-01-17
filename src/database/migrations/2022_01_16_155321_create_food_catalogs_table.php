<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_catalogs', function (Blueprint $table) {
            $table->id();

            $table->string('name', 512);
            $table->string('maker', 255)->nullable();
            $table->float('calorie')->nullable();
            $table->text('memo')->nullable();
            $table->binary('picture')->nullable();
            $table->string('url', 1024)->nullable();
            $table->boolean('is_master')->default(false);

            // user ID
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);;
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('food_catalog');
    }
}
