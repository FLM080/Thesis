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
            $table->integer('workout_day_id')->unsigned();
            $table->foreign('workout_day_id')->references('workout_day_id')->on('workout_day')->onDelete('cascade');
            $table->integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('exercise_id')->on('exercise')->onDelete('cascade');
            $table->unsignedTinyInteger('exercise_workout_sets');
            $table->unsignedTinyInteger('exercise_workout_reps');
            $table->integer('order')->unsigned();
            $table->unique(['workout_day_id', 'exercise_id']);
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
