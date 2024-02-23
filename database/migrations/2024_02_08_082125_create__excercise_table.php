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
            $table->increments('id');
            $table->string('exercise_name');
            $table->text('exercise_description');
            $table->enum('exercise_type', ['bodyweight', 'weight training', 'with cardio', 'no equipment']);
            $table->enum('strength_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('exercise_goal', ['lose weight', 'build muscle', 'maintain weight']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_excercise');
    }
};
