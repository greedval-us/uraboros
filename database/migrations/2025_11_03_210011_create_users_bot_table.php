<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bot_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('telegram_id')->unique();
            $table->string('username')->nullable()->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->unsignedInteger('requests')->default(10);
            $table->unsignedInteger('count_requests')->default(0);
            $table->timestamp('last_request_at')->nullable();

            $table->boolean('premium')->default(false)->index();
            $table->timestamp('premium_start')->nullable();
            $table->timestamp('premium_end')->nullable();

            $table->timestamp('free_requests_reset_at')->nullable();

            $table->string('lang', 10)->default('ru')->index();

            $table->string('referral_code', 32)->unique()->nullable();
            $table->unsignedInteger('referral_count')->default(0);
            $table->unsignedBigInteger('referred_by')->nullable();

            $table->boolean('blocked')->default(false);
            $table->timestamps();

            $table->index(['telegram_id', 'premium', 'premium_end', 'lang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_users');
    }
};
