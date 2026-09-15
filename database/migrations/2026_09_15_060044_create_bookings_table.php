<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 16)->unique();
            $table->morphs('bookable'); // Schedule, HotelRoom or Activity
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('dial_code', 8)->default('+62');
            $table->string('phone', 32);
            $table->string('nationality', 64);
            $table->date('travel_date');
            $table->date('check_out')->nullable()->comment('Hotel stays only');
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);
            $table->unsignedTinyInteger('nights')->default(1);
            $table->unsignedInteger('unit_price_adult');
            $table->unsignedInteger('unit_price_child')->default(0);
            $table->unsignedInteger('total');
            $table->string('currency', 3)->default('IDR');
            $table->string('status', 32)->default('pending');
            $table->string('payment_status', 32)->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'travel_date']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
