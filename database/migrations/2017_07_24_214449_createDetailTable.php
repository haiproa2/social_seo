<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_data')->create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name', 250)->nullable();
            $table->integer('id_column')->default(0);
            $table->string('keyword_column', 250)->nullable();
            $table->string('value_column', 250)->nullable();
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
        Schema::connection('mysql_data')->dropIfExists('details');
    }
}
