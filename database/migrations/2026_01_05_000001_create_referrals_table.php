<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('label')->nullable();
            $table->string('referrer_name')->nullable();
            $table->string('referrer_contact')->nullable();
            $table->unsignedTinyInteger('discount_percentage');
            $table->unsignedTinyInteger('commission_percentage')->nullable();
            $table->decimal('commission_flat', 10, 2)->nullable();
            $table->unsignedInteger('max_usage')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
