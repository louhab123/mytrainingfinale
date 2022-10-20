<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdForeignToQuizSimpleGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_simple_groups', function (Blueprint $table) {


            // $table->integer('service_id')->unsigned()->nullable();
            $table->foreignId('service_id')->references('id')->on('services');
            // $table->foreignId('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_simple_groups', function (Blueprint $table) {
            //
        });
    }
}
