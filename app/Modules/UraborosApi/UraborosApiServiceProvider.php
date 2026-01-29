<?php

namespace App\Modules\UraborosApi;

use Illuminate\Support\ServiceProvider;
use App\Modules\UraborosApi\Contracts\UraborosApiInterface;
use App\Modules\UraborosApi\Services\UraborosApiService;

class UraborosApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UraborosApiInterface::class,
            UraborosApiService::class
        );
    }

    public function boot(): void
    {
        // пока ничего не нужно
    }
}
