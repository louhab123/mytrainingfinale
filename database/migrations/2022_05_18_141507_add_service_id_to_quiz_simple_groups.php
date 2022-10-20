<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdToQuizSimpleGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_simple_groups', function (Blueprint $table) {
             $table->unsignedBigInteger('service_id')->default(23);
            $table->foreignId('service_id')->references('id')->on('services')->default(23);
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
