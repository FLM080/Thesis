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
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('workout_name');
            $table->string('workout_description');
            $table->tinyInteger('workout_days');
            $table->enum('strength_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('workout_goal', ['lose weight', 'build muscle', 'maintain weight']);
            $table->enum('workout_type', ['bodyweight', 'weight training', 'with cardio', 'no equipment']);
            $table->enum('gender', ['Male', 'Female']);
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
