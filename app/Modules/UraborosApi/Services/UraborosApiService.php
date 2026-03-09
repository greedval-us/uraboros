<?php

namespace App\Modules\UraborosApi\Services;

use Illuminate\Support\Facades\Http;
use App\Modules\UraborosApi\Contracts\UraborosApiInterface;
use App\Modules\UraborosApi\Exceptions\UraborosApiException;

class UraborosApiService implements UraborosApiInterface
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.uraboros_api.url');
        $this->token   = config('services.uraboros_api.token');
    }

    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->token)
            ->acceptJson()
            ->timeout(60)
            ->retry(2, 200);
    }

    protected function request(string $method, string $uri, array $data = []): array
    {
        $response = $this->client()->{$method}($uri, $data);

        if ($response->failed()) {
            throw new UraborosApiException(
                $response->json('message') ?? 'Uraboros API error',
                $response->status()
            );
        }

        return $response->json() ?? [];
    }

    public function get(string $uri, array $params = []): array
    {
        return $this->request('get', $uri, $params);
    }

    public function post(string $uri, array $data = []): array
    {
        return $this->request('post', $uri, $data);
    }
}
