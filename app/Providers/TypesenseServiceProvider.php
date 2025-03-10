<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Typesense\Client as TypesenseClient;

class TypesenseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TypesenseClient::class, function () {
            return new TypesenseClient([
                'api_key' => config('services.typesense.api_key'),
                'nodes' => [
                    [
                        'host' => config(
                            'services.typesense.host',
                            'localhost'
                        ),
                        'port' => config('services.typesense.port', '8108'),
                        'protocol' => config(
                            'services.typesense.protocol',
                            'http'
                        ),
                    ],
                ],
                'connection_timeout_seconds' => 2,
            ]);
        });
    }
}
