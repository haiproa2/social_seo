<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 250)->nullable();
            $table->string('username', 250)->unique();
            $table->string('email', 250)->unique();
            $table->string('password', 250);
            $table->rememberToken();
            $table->string('name', 250)->nullable();
            $table->string('telephone', 250)->nullable();
            $table->string('photo', 250)->nullable();
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
        Schema::dropIfExists('users');
    }
}
