<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Location & Harbor Proximity fields behind the Figma 1:7501 hotel editor sidebar. */
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('region', 80)->nullable()->after('address');
            $table->string('harbor_distance', 120)->nullable()->after('full_address');
            $table->string('coordinates', 60)->nullable()->after('harbor_distance');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['region', 'harbor_distance', 'coordinates']);
        });
    }
};
