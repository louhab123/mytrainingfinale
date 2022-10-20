<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserActivite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('user_activite', function (Blueprint $table) {
            // $table->integer('user_id')->unsigned();
            // $table->integer('activite_id')->unsigned();
            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('activite_id')->references('id')->on('activites')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('activite_id')->constrained('activites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
