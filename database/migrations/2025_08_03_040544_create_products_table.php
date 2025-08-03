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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_sw')->nullable(); // Swahili translation
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('description_sw')->nullable(); // Swahili translation
            $table->text('full_description')->nullable();
            $table->text('full_description_sw')->nullable(); // Swahili translation
            $table->string('duration');
            $table->string('duration_sw')->nullable(); // Swahili translation
            $table->integer('participants')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // For multiple images
            $table->string('status')->default('active'); // active, inactive, draft
            $table->integer('sort_order')->default(0);
            $table->json('objectives')->nullable(); // Program objectives/goals
            $table->json('requirements')->nullable(); // Program requirements
            $table->string('location')->nullable();
            $table->string('location_sw')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};