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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_sw')->nullable(); // Swahili translation
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->text('excerpt_sw')->nullable(); // Swahili translation
            $table->longText('content');
            $table->longText('content_sw')->nullable(); // Swahili translation
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable(); // For multiple images
            $table->string('story_type')->default('impact'); // impact, testimonial, success, community
            $table->string('author_name')->nullable();
            $table->string('author_title')->nullable(); // e.g., "Program Beneficiary", "Volunteer"
            $table->string('author_title_sw')->nullable();
            $table->string('author_image')->nullable();
            $table->string('location')->nullable();
            $table->string('location_sw')->nullable();
            $table->date('story_date')->nullable(); // When the story/event happened
            $table->string('status')->default('published'); // published, draft, archived
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->integer('sort_order')->default(0);
            $table->json('tags')->nullable(); // Story tags for categorization
            $table->string('video_url')->nullable(); // YouTube, Vimeo, etc.
            $table->text('meta_description')->nullable(); // SEO
            $table->text('meta_description_sw')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['status', 'is_featured']);
            $table->index(['story_type', 'status']);
            $table->index('story_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};