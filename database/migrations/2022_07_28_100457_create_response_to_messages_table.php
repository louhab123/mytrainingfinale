<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_to_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->foreignId('agent_id')->constrained('users');
            $table->foreignId('formateur_id')->constrained('users');
            $table->boolean('lu');
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
        Schema::dropIfExists('response_to_messages');
    }
}
