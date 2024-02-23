<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercise_workout_connect', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('workout_id')->unsigned();
            $table->foreign('workout_id')->references('id')->on('workout')->onDelete('cascade');
            $table->Integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('id')->on('exercise')->onDelete('cascade');
            $table->unsignedInteger('sets');
            $table->unsignedInteger('reps');
            $table->integer('day');
            $table->tinyInteger('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_excercise__workout_connect');
    }
};
