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
        Schema::create('workout', function (Blueprint $table) {
            $table->increments('workout_id');
            $table->Integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('workout_name');
            $table->text('workout_description');
            $table->tinyInteger('workout_days');
            $table->enum('workout_strength_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('workout_goal', ['lose weight', 'build muscle', 'maintain weight']);
            $table->enum('workout_type', ['bodyweight', 'weight training', 'with cardio', 'no equipment']);
            $table->enum('workout_gender', ['Male', 'Female']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_workout');
    }
};
