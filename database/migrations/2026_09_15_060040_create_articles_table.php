<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('excerpt');
            $table->text('subtitle')->nullable();
            $table->text('lead')->nullable();
            $table->text('lead_follow')->nullable();
            $table->longText('body')->nullable();
            $table->json('content')->nullable()->comment('Structured editorial blocks (toc, tables, timetables, tips)');
            $table->string('image')->comment('Cover image, relative to public/images/articles');
            $table->string('hero_caption')->nullable();
            $table->string('author_name');
            $table->string('author_role')->nullable();
            $table->unsignedTinyInteger('read_time_minutes')->default(5);
            $table->unsignedInteger('views')->default(0);
            $table->json('tags')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status', 32)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
