<?php

namespace App\Console\Commands;

use App\Models\Affiliate;
use App\Models\Church;
use App\Models\MongoDB\Church as MongoDBChurch;
use App\Traits\HasTypesenseClient;
use Illuminate\Console\Command;

class TypesenseChurchSync extends Command
{
    use HasTypesenseClient;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'typesense:churches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = $this->typesense();
        $schema = MongoDBChurch::getSchema();

        $collections = collect($client->collections->retrieve());
        $collection = $collections->first(fn ($c) => $c['name'] === 'churches');
        if (! $collection) {
            $client->collections->create($schema);
        }

        $affiliates = Affiliate::all();
        $affiliates->each(function (Affiliate $affiliate) use ($client) {
            $affiliate->run(function (Affiliate $affiliate) use ($client) {
                Church::chunk(100, function ($churches) use ($client) {
                    $documents = $churches
                        ->map(fn ($church) => $church->toSearchableArray())
                        ->toArray();

                    $response = $client->collections[
                        'churches'
                    ]->documents->import($documents, [
                        'action' => 'upsert',
                    ]);
                });
            });
        });
    }
}
