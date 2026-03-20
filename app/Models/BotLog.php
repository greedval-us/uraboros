<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotLog extends Model
{
    use HasFactory;

    protected $table = 'bot_logs';

    protected $fillable = [
        'level',
        'event',
        'action',
        'message',
        'telegram_id',
        'chat_id',
        'message_id',
        'callback_type',
        'context',
        'exception_class',
        'exception_message',
        'exception_code',
        'exception_file',
        'exception_line',
    ];

    protected $casts = [
        'telegram_id' => 'integer',
        'message_id' => 'integer',
        'exception_code' => 'integer',
        'exception_line' => 'integer',
        'context' => 'array',
    ];
}

