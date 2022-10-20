<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('quiz_simple_group_id')->constrained('quiz_simple_groups');
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
        Schema::dropIfExists('simple_quizzes');
    }
}
