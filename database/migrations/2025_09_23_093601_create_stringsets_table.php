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
    Schema::create('string_sets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->decimal('string_1_gauge', 5, 2)->nullable();
        $table->decimal('string_2_gauge', 5, 2)->nullable();
        $table->decimal('string_3_gauge', 5, 2)->nullable();
        $table->decimal('string_4_gauge', 5, 2)->nullable();
        $table->decimal('string_5_gauge', 5, 2)->nullable();
        $table->decimal('string_6_gauge', 5, 2)->nullable();
        $table->integer('scale_length_mm'); // en milímetros
        $table->foreignId('tuning_id')->nullable()->constrained('tunings')->onDelete('set null');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stringsets');
    }
};
