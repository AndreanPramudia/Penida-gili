<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Editorial authors selectable from the article editor's AUTHOR bar (Figma 1:8366). */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120)->unique();
            $table->string('role', 120)->nullable();
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('author_id')->nullable()->after('author_role')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('author_id');
        });

        Schema::dropIfExists('authors');
    }
};
