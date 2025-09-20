<?php
// database/migrations/2024_01_01_000003_add_fields_to_content_blocks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->text('description')->nullable()->after('type');
            $table->boolean('is_active')->default(true)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_active']);
        });
    }
};
