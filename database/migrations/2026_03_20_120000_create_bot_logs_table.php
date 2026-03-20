<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bot_logs', function (Blueprint $table) {
            $table->id();

            $table->string('level', 20)->index();
            $table->string('event', 50)->index();

            $table->string('action', 100)->nullable()->index();
            $table->text('message')->nullable();

            $table->unsignedBigInteger('telegram_id')->nullable()->index();
            $table->string('chat_id', 64)->nullable()->index();
            $table->unsignedBigInteger('message_id')->nullable()->index();
            $table->string('callback_type', 100)->nullable()->index();

            $table->json('context')->nullable();

            $table->string('exception_class')->nullable();
            $table->text('exception_message')->nullable();
            $table->unsignedInteger('exception_code')->nullable();
            $table->string('exception_file')->nullable();
            $table->unsignedInteger('exception_line')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_logs');
    }
};

