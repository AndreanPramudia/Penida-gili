<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('Hotel');
            $table->string('partner_label')->nullable();
            $table->unsignedTinyInteger('stars')->default(5);
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->text('description');
            $table->string('address');
            $table->string('full_address')->nullable();
            $table->string('image')->comment('Card image, relative to public/images/hotels');
            $table->json('gallery')->nullable();
            $table->json('amenities')->nullable();
            $table->string('status', 32)->default('active');
            $table->timestamps();

            $table->index(['status', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
