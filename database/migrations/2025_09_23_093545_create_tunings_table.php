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
        Schema::create('tunings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('instrument_type');
            $table->string('tuning_1')->nullable();
            $table->string('tuning_2')->nullable();
            $table->string('tuning_3')->nullable();
            $table->string('tuning_4')->nullable();
            $table->string('tuning_5')->nullable();
            $table->string('tuning_6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tunings');
    }
};
