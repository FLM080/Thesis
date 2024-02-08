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
        Schema::create('excercise', function (Blueprint $table) {
            $table->id();
            $table->string('excercise_name');
            $table->string('excercise_description');
            $table->enum('excercise_type', ['bodyweight', 'weight training', 'cardio', 'no equipment']);
            $table->enum('strength_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('excercise_goal', ['lose weight', 'build muscle', 'maintain weight']);
            
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
