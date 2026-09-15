<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('badge')->nullable();
            $table->string('category');
            $table->string('location');
            $table->string('place_label')->nullable()->comment('Short region label for cards, e.g. South Bali');
            $table->time('opens_at')->nullable();
            $table->time('closes_at')->nullable();
            $table->string('duration_label')->nullable();
            $table->text('description');
            $table->text('intro')->nullable();
            $table->text('summary')->nullable();
            $table->string('summary_image')->nullable();
            $table->string('image')->comment('Card image, relative to public/images/activities');
            $table->json('gallery')->nullable();
            $table->json('highlights')->nullable();
            $table->json('experiences')->nullable();
            $table->json('included')->nullable();
            $table->json('excluded')->nullable();
            $table->json('days')->nullable();
            $table->unsignedInteger('price_adult')->comment('IDR, whole rupiah');
            $table->unsignedInteger('price_child')->default(0);
            $table->unsignedInteger('price_was')->nullable();
            $table->string('price_note')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->unsignedInteger('sold_count')->default(0);
            $table->string('status', 32)->default('active');
            $table->timestamps();

            $table->index(['status', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
