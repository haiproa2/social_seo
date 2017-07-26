<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_data')->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 250)->nullable();
            $table->string('title', 250)->nullable();
            $table->string('slug', 250)->nullable();
            $table->text('content')->nullable();
            $table->string('seo_title', 250)->nullable();
            $table->string('seo_keywords', 250)->nullable();
            $table->string('seo_description', 250)->nullable();
            $table->string('photo', 250)->nullable();
            $table->integer('highlight')->default(0);
            $table->integer('view')->default(0);
            $table->integer('no')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->integer('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_data')->dropIfExists('posts');
    }
}
