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
    Schema::table('schedules', function (Blueprint $table) {
        $table->foreignId('route_id')
            ->nullable()
            ->after('vessel_id')
            ->constrained('routes')
            ->restrictOnDelete();
    });
}

public function down(): void
{
    Schema::table('schedules', function (Blueprint $table) {
        $table->dropForeign(['route_id']);
        $table->dropColumn('route_id');
    });
}
};
