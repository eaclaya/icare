<?php
namespace App\Traits;

use Typesense\Client;

trait HasTypesenseClient
{
    /**
     * Get the Typesense client.
     *
     * @return Client
     */
    public function typesense(): Client
    {
        return new Client([
            "api_key" => config("services.typesense.api_key"),
            "nodes" => [
                [
                    "host" => config("services.typesense.host"),
                    "port" => config("services.typesense.port"),
                    "protocol" => config("services.typesense.protocol"),
                ],
            ],
            "connection_timeout_seconds" => 2,
        ]);
    }
}
