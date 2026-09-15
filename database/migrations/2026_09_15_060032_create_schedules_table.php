<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_operator_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vessel_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('from_port_id')->constrained('ports')->restrictOnDelete();
            $table->foreignId('to_port_id')->constrained('ports')->restrictOnDelete();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->unsignedInteger('price_adult')->comment('IDR, whole rupiah');
            $table->unsignedInteger('price_child')->comment('IDR, whole rupiah');
            $table->unsignedInteger('price_foreign')->nullable()->comment('IDR, optional fare for foreign passengers');
            $table->json('days')->nullable()->comment('Operating days e.g. ["Mon","Tue"]; null = daily');
            $table->string('status', 32)->default('draft');
            $table->timestamps();

            // The public search filters by port pair + status, then sorts by departure.
            $table->index(['from_port_id', 'to_port_id', 'status', 'departure_time'], 'schedules_search_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
