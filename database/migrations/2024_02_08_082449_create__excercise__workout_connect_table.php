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
        Schema::create('excercise-workout connect', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('workout_id');
            $table->unsignedInteger('excercise_id');
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
