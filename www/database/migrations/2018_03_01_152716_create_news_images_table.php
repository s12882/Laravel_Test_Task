<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('news_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('original_file_name');
            $table->string('type');
            $table->integer('uploaded_by')->unsigned()->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
            $table->integer('news_id')->unsigned()->nullable();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('news_images');
        Schema::enableForeignKeyConstraints();
    }
}
