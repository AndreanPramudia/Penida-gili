<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Fields behind the Figma 1:8059 article editor: alt text, reader segment and the side-rail booking widget. */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('hero_alt', 200)->nullable()->after('hero_caption');
            $table->string('reader_segment', 80)->nullable()->after('category');
            $table->boolean('embed_booking_widget')->default(false)->after('is_featured');
            $table->string('widget_route', 120)->nullable()->after('embed_booking_widget');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['hero_alt', 'reader_segment', 'embed_booking_widget', 'widget_route']);
        });
    }
};
