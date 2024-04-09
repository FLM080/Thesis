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
        Schema::create('exercise', function (Blueprint $table) {
            $table->increments('exercise_id');
            $table->smallInteger('muscle_group_id')->unsigned();
            $table->foreign('muscle_group_id')->references('muscle_group_id')->on('muscle_groups')->onDelete('cascade');
            $table->string('exercise_name', 40);
            $table->string('exercise_description',150);
            $table->enum('exercise_type', ['bodyweight', 'weight training', 'with cardio', 'no equipment']);
            $table->enum('exercise_strength_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('exercise_goal', ['lose weight', 'build muscle', 'maintain weight']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_exercise');
    }
};
