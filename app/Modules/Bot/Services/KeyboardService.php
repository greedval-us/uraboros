<?php

namespace App\Modules\Bot\Services;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

class KeyboardService
{
    public function build(string $key, string $lang): Keyboard|ReplyKeyboard
    {
        $class = config("bot.keyboards.$key");

        if (! $class) {
            throw new \InvalidArgumentException("Keyboard [$key] not found");
        }

        $keyboard = app($class);

        if (! $keyboard instanceof KeyboardBuilderInterface) {
            throw new \LogicException("Invalid keyboard [$key]");
        }

        return $keyboard->execute($lang);
    }
}
