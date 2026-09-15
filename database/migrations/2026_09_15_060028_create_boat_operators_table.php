<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boat_operators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('tagline')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->string('image')->comment('Card image, relative to public/images/boats');
            $table->string('hero_image')->nullable();
            $table->unsignedSmallInteger('top_speed_knots')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->json('facilities')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boat_operators');
    }
};
