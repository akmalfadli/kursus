<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('base_amount', 10, 2)->nullable()->after('user_phone');
            $table->decimal('referral_discount_amount', 10, 2)->default(0)->after('amount');
            $table->decimal('referral_commission_amount', 10, 2)->default(0)->after('referral_discount_amount');
            $table->unsignedTinyInteger('referral_discount_percentage')->nullable()->after('referral_commission_amount');
            $table->foreignId('referral_id')->nullable()->after('payment_method')->constrained()->nullOnDelete();
            $table->string('referral_code')->nullable()->after('referral_id');
            $table->enum('referral_commission_status', ['pending', 'paid'])->nullable()->after('referral_code');
            $table->timestamp('referral_commission_paid_at')->nullable()->after('referral_commission_status');
            $table->timestamp('referral_usage_recorded_at')->nullable()->after('referral_commission_paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['referral_id']);
            $table->dropColumn([
                'base_amount',
                'referral_discount_amount',
                'referral_commission_amount',
                'referral_discount_percentage',
                'referral_id',
                'referral_code',
                'referral_commission_status',
                'referral_commission_paid_at',
                'referral_usage_recorded_at',
            ]);
        });
    }
};
