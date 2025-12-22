<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tunings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');               // Nombre del set
            $table->string('material')->default('nickel');
            $table->text('notes');                // Ej: E4,B3,G3,D3,A2,E2
            $table->text('gauges');               // Ej: 0.010,0.013,0.017,0.026,0.036,0.046
            $table->text('tensions');             // Ej: 17.1,16.9,17.2,17.0,17.0,17.1
            $table->decimal('total_tension', 6, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tunings');
    }
};
