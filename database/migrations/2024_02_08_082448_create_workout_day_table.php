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
        Schema::create('workout_day', function (Blueprint $table) {
            $table->bigIncrements('workout_day_id')->unsigned();
            $table->integer('workout_id')->unsigned();
            $table->foreign('workout_id')->references('workout_id')->on('workout')->onDelete('cascade');
            $table->string('workout_day_name', 40);
            $table->enum('workout_day', ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->unique(['workout_id', 'workout_day_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_day');
    }
};
