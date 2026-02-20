<?php

namespace App\Services\Telegram\Actions\Request;

use App\Services\Telegram\Actions\AbstractTelegramAction;



class InfoAction extends AbstractTelegramAction
{
    public function execute(string $id): ?array
    {
        try {
            $response = $this->madeline()->getFullInfo(id: $id);
            return $response;
        } catch (\Exception $e) {
            $this->logError($e, [$id]);
            return ['error' => $e->getMessage()];
        }
    }
}
