<?php

namespace App\Modules\UraborosApi\Contracts;

interface UraborosApiInterface
{
    public function get(string $uri, array $params = []): array;

    public function post(string $uri, array $data = []): array;
}
