<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronjobResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_data')->create('cronjob_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->default(0);
            $table->string('link', 250)->nullable();
            $table->string('title', 250)->nullable();
            $table->string('status', 250)->nullable();
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
        Schema::connection('mysql_data')->dropIfExists('cronjob_results');
    }
}
