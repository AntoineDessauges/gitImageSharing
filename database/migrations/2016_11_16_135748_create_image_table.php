<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid("version")->nullable();
            $table->string("filename")->unique();
            $table->string("original_filename");
            $table->unsignedInteger("album_id");
            $table->foreign("album_id")->references("id")->on("albums");
            $table->unsignedInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
            $table->softDeletes();
        });
        /*Schema::create("album_image",function (Blueprint $table) {
            $table->unsignedInteger("image_id");
            $table->foreign("image_id")->references("id")->on("images");

            $table->unsignedInteger("album_id");
            $table->foreign("album_id")->references("id")->on("albums");
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("album_image");
        Schema::dropIfExists('images');

    }
}
