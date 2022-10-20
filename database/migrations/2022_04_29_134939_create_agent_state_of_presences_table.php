<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentStateOfPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_state_of_presences', function (Blueprint $table) {
            $table->id();
            $table->string('agent');
            $table->string('etat');
            $table->integer('agent_id');
            $table->string('formation_id');
            $table->string('formation_type');
            $table->float('cumul');
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
        Schema::dropIfExists('agent_state_of_presences');
    }
}
