<?php
// database/migrations/2024_01_01_000001_create_content_blocks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('text'); // text, image, json
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
