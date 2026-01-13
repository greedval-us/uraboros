<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chennels_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('chennel');
            $table->unsignedBigInteger('telegram_id');
            $table->timestamp('last_request')->nullable();
            $table->timestamps();

            $table->index(['chennel', 'telegram_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chennels_monitoring');
    }
};
