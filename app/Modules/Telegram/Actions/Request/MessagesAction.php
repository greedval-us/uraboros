<?php

namespace App\Services\Telegram\Actions\Request;

use App\Services\Telegram\Actions\AbstractTelegramAction;

class MessagesAction extends AbstractTelegramAction
{
    public function execute(array $filter): ?array
    {
        try {
            $response = $this->madeline()->messages->search($filter);
            return $response;
        } catch (\Exception $e) {
            $this->logError($e, $filter);
            return ['error' => $e->getMessage()];
        }
    }
}
