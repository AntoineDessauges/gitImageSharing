<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text("text");
            $table->unsignedInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->unsignedInteger("image_id")->nullable();
            $table->foreign("image_id")->references("id")->on("images");
            $table->unsignedInteger("parent_id")->nullable();
            $table->foreign("parent_id")->references("id")->on("comments");
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
        Schema::dropIfExists('comments');
    }
}
