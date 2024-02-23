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
        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->id();
            $table->Integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('id')->on('exercise')->onDelete('cascade');
            $table->string('muscle_group_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muscle_groups');
    }
};
