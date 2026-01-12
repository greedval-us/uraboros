<?php

namespace App\Modules\Bot\Contracts;

use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

interface KeyboardBuilderInterface
{
    public function execute(string $lang, array $keyboard = []): Keyboard|ReplyKeyboard;
}
