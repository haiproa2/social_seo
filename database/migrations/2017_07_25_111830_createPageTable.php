<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_data')->create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parent')->default(0);
            $table->string('type', 250)->nullable();
            $table->integer('template')->default(0);
            $table->string('title', 250)->nullable();
            $table->string('slug', 250)->nullable();
            $table->text('content')->nullable();
            $table->string('seo_title', 250)->nullable();
            $table->string('seo_keyword', 250)->nullable();
            $table->string('seo_description', 250)->nullable();
            $table->string('photo', 250)->nullable();
            $table->integer('highlight')->default(0);
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
        Schema::connection('mysql_data')->dropIfExists('pages');
    }
}
