<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_prices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            // 🔥 Clave técnica para poder usar UNIQUE
            $table->string('type_key');

            // 🔥 Traducciones
            $table->json('type');

            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_free')->default(false);

            $table->timestamps();

            // ✅ Ahora sí funciona
            $table->unique(['tour_id', 'type_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_prices');
    }
};
