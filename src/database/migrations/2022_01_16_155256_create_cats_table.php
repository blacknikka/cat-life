<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->date('birth')->nullable();
            $table->text('description')->nullable();
            $table->text('picture')->nullable()->comment("path to the image");

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
        Schema::table('cats', function (Blueprint $table) {
            $table->dropForeign('cats_user_id_foreign');
        });
        Schema::dropIfExists('cats');
    }
}
