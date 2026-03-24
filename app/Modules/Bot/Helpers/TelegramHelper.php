<?php

namespace App\Modules\Bot\Helpers;

use App\Modules\Bot\Enums\LinkType;

class TelegramHelper
{
    public static function extractInfo(string $input, int $mode = 0): array
    {
        $input = trim($input);

        $patterns = [
            'joinchat' => '/(?:https:\/\/)?t\.me\/{1,2}joinchat\/?(?<hash>[^\s\/]+)/i',
            'plus' => '/(?:https:\/\/)?t\.me\/{1,2}\+(?<hash>[^\s\/]+)/i',

            // t.me/username
            'channel_link' => '/(?:https:\/\/)?t\.me\/{1,2}(?<channelname>[a-zA-Z0-9_]{3,})\/?$/i',

            // @username
            'at_username' => '/^@(?<channelname>[a-zA-Z0-9_]{3,})$/',

            // просто username (обязательно содержит букву или _)
            'plain_username' => '/^(?=.*[a-zA-Z_])(?<channelname>[a-zA-Z0-9_]{3,})$/',

            'user_id' => '/^\d+$/',
            'chat_id' => '/^-\d+$/',
        ];

        // 🔥 1. numeric IDs (ВСЕГДА раньше username!)
        if ($mode === 1) {

            if (preg_match($patterns['chat_id'], $input)) {
                return [
                    'channel' => '',
                    'value' => $input,
                    'type' => LinkType::ChatId
                ];
            }

            if (preg_match($patterns['user_id'], $input)) {
                return [
                    'channel' => '',
                    'value' => $input,
                    'type' => LinkType::UserId
                ];
            }
        }

        // 2. joinchat hash
        if (preg_match($patterns['joinchat'], $input, $m)) {
            return [
                'channel' => '',
                'value' => $m['hash'] ?? '',
                'type' => LinkType::JoinchatHash
            ];
        }

        // 3. +hash
        if (preg_match($patterns['plus'], $input, $m)) {
            return [
                'channel' => '',
                'value' => $m['hash'] ?? '',
                'type' => LinkType::PlusHash
            ];
        }

        // 4. t.me/username
        if (preg_match($patterns['channel_link'], $input, $m)) {
            return [
                'channel' => $m['channelname'] ?? '',
                'value' => '',
                'type' => LinkType::Channelname
            ];
        }

        // 5. @username
        if (preg_match($patterns['at_username'], $input, $m)) {
            return [
                'channel' => $m['channelname'] ?? '',
                'value' => '',
                'type' => LinkType::Channelname
            ];
        }

        // 6. просто username
        if (preg_match($patterns['plain_username'], $input, $m)) {
            return [
                'channel' => $m['channelname'] ?? '',
                'value' => '',
                'type' => LinkType::Channelname
            ];
        }

        // fallback
        return [
            'channel' => '',
            'value' => '',
            'type' => LinkType::Unknown
        ];
    }
}
