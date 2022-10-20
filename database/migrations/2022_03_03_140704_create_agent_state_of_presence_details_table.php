<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentStateOfPresenceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_state_of_presence_details', function (Blueprint $table) {
            $table->id();
            $table->string('agent');
            $table->string('etat');
            $table->string('formation_id');
            $table->integer('agent_id');
            $table->string('formation_type');
            $table->time('startTime')->nullable();
            $table->time('endTime')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('agent_state_of_presence_details');
    }
}
