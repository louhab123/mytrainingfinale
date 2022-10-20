<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizsimplegroup_id')->constrained('quiz_simple_groups')->cascadeOnDelete();
            $table->float('note')->constrained('response_agents');
            $table->foreignId('agent_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('note_agents');
    }
}
