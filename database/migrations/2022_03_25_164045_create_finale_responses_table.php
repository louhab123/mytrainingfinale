<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinaleResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finale_responses', function (Blueprint $table) {
            $table->id();
            $table->string('response');
            $table->boolean('value');
            // $table->foreignId('finale_quizze_id')->constrained('finale_quizzes');
            $table->foreignId('finale_quiz_id')->references('id')->on('finale_quizzes');
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
        Schema::dropIfExists('finale_responses');
    }
}
