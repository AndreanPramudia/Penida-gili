<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // The Figma editor (1:8502) has no address fields; existing rows keep theirs.
            $table->string('location')->nullable()->change();

            $table->boolean('instant_confirmation')->default(true)->after('duration_label');
            $table->string('cancellation_policy', 80)->nullable()->after('instant_confirmation');
            $table->text('important_notes')->nullable()->after('excluded');
            $table->boolean('is_public')->default(true)->after('status');
            $table->boolean('dual_pricing')->default(false)->after('price_was');
            $table->unsignedInteger('price_foreign')->nullable()->after('dual_pricing');
            $table->unsignedInteger('max_daily_capacity')->nullable()->after('price_note');
            $table->timestamp('publish_at')->nullable()->after('is_public')->comment('Set when status is scheduled to go live');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['instant_confirmation', 'cancellation_policy', 'important_notes', 'is_public', 'dual_pricing', 'price_foreign', 'max_daily_capacity', 'publish_at']);
            $table->string('location')->nullable(false)->change();
        });
    }
};
