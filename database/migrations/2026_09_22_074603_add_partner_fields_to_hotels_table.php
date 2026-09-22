<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Fields behind the Figma 1:7501 hotel editor sidebar (location, fastboat bundle, OTA sync, commission). */
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('region', 80)->nullable()->after('address');
            $table->string('harbor_distance', 120)->nullable()->after('full_address');
            $table->string('coordinates', 60)->nullable()->after('harbor_distance');
            $table->boolean('transfer_bundle')->default(true)->after('coordinates');
            $table->string('departure_port', 120)->nullable()->after('transfer_bundle');
            $table->string('arrival_pier', 120)->nullable()->after('departure_port');
            $table->boolean('harbor_pickup')->default(true)->after('arrival_pier');
            $table->boolean('auto_sync')->default(true)->after('harbor_pickup');
            $table->unsignedTinyInteger('commission_rate')->default(15)->after('auto_sync');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn([
                'region', 'harbor_distance', 'coordinates', 'transfer_bundle', 'departure_port',
                'arrival_pier', 'harbor_pickup', 'auto_sync', 'commission_rate',
            ]);
        });
    }
};
