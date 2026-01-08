<?php

use App\Modules\Bot\Enums\KeyboardKey;
use App\Modules\Bot\Keyboards\ReplyMenuKeyboard;

return [
    'keyboards' => [
        KeyboardKey::ReplyMenu->value => ReplyMenuKeyboard::class,
    ],
];
