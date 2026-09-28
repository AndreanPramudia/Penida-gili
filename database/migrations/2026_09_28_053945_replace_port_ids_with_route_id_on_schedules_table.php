<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::table('schedules', function (Blueprint $table) {
        $table->dropIndex('schedules_search_index');
        $table->dropForeign(['from_port_id']);
        $table->dropForeign(['to_port_id']);
        $table->dropColumn(['from_port_id', 'to_port_id']);
    });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreignId('from_port_id')
                ->nullable()
                ->constrained('ports')
                ->restrictOnDelete();

            $table->foreignId('to_port_id')
                ->nullable()
                ->constrained('ports')
                ->restrictOnDelete();

            $table->dropForeign(['route_id']);
            $table->dropColumn('route_id');
        });
    }
};