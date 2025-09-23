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
    Schema::create('tensions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('string_set_id')->constrained('string_sets')->onDelete('cascade');
        $table->foreignId('tuning_id')->constrained('tunings')->onDelete('cascade');
        $table->decimal('tension_1_kg', 6, 2)->nullable();
        $table->decimal('tension_2_kg', 6, 2)->nullable();
        $table->decimal('tension_3_kg', 6, 2)->nullable();
        $table->decimal('tension_4_kg', 6, 2)->nullable();
        $table->decimal('tension_5_kg', 6, 2)->nullable();
        $table->decimal('tension_6_kg', 6, 2)->nullable();
        $table->decimal('total_tension', 8, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tensions');
    }
};
