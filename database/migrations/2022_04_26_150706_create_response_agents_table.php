<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('response');
            $table->boolean('value');
            $table->foreignId('simple_response_id')->references('id')->on('simple_responses')->cascadeOnDelete();
            $table->string('type');
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
        Schema::dropIfExists('response_agents');
    }
}
