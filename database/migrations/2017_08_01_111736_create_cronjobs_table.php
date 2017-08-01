<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_data')->create('cronjobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cate_id')->default(0);
            $table->string('title', 250)->nullable();
            $table->string('domain', 250)->nullable();
            $table->string('url_topic', 250)->nullable();
            $table->string('url_page', 250)->nullable();
            $table->string('count_page', 250)->nullable();
            $table->string('tag_list', 250)->nullable();
            $table->string('tag_link', 250)->nullable();
            $table->string('tag_title', 250)->nullable();
            $table->integer('where_title')->default(0);
            $table->string('tag_desc', 250)->nullable();
            $table->integer('where_desc')->default(0);
            $table->string('tag_content', 250)->nullable();
            $table->string('tag_photo', 250)->nullable();
            $table->integer('where_photo')->default(0);
            $table->string('tag_remove', 250)->nullable();
            $table->integer('no')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::connection('mysql_data')->dropIfExists('cronjobs');
    }
}
