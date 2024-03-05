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
            $table->increments('exercise_workout_connect_id')->unsigned();
            $table->Integer('workout_id')->unsigned();
            $table->foreign('workout_id')->references('workout_id')->on('workout')->onDelete('cascade');
            $table->Integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('exercise_id')->on('exercise')->onDelete('cascade');
            $table->unsignedTinyInteger('exercise_workout_sets');
            $table->unsignedTinyInteger('exercise_workout_reps');
            $table->unsignedTinyInteger('exercise_workout_day');
            $table->unsignedTinyInteger('exercise_workout_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_exercise__workout_connect');
    }
};
