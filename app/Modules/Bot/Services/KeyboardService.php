<?php

namespace App\Modules\Bot\Services;

use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

class KeyboardService
{
    public function build(string $key, string $lang): Keyboard|ReplyKeyboard
    {
        $class = config("bot.keyboards.$key");

        if (! $class) {
            throw new \InvalidArgumentException("Keyboard [$key] not found in config");
        }

        $keyboard = app($class);

        if (! $keyboard instanceof KeyboardBuilderInterface) {
            throw new \LogicException("Keyboard [$key] must implement KeyboardBuilderInterface");
        }

        return $keyboard->execute($lang);
    }
}
