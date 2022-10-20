<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinaleQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finale_quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('quiz_finale_group_id')->constrained('group_finale_quizzes');
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
        Schema::dropIfExists('finale_quizzes');
    }
}
