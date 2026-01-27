<?php

namespace App\Modules\Bot\Enums;

enum StorageKey: string
{
    case LANG    = 'lang';
    case QUERY   = 'query';
    case MESSAGE = 'message';
    case MENU    = 'menu';
    case CHANNEL = 'channel';
}
