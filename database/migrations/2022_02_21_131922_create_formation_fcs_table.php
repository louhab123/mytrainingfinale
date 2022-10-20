<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationFcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation_fcs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('activite_id')->constrained('activites');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('user_id')->constrained('users');
            $table->string('statu');
            $table->date('dateDebut');
            $table->date('dateFin');
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
        Schema::dropIfExists('formation_fcs');
    }
}
