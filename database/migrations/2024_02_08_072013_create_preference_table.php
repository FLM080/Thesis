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
        Schema::create('preference', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->enum('goal', ['None','lose weight', 'build muscle', 'maintain weight']);
            $table->enum('workout_type', ['None','bodyweight', 'weight training', 'cardio', 'no equipment']);
            $table->enum('strength_level', ['None','beginner', 'intermediate', 'advanced']);
            
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preference');
    }
};
