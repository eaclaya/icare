<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\Church;
use Illuminate\Database\Seeder;
use MongoDB\Client as MongoClient;

class ChurchMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder copies churches from the primary database to a MongoDB collection.
     *
     * @return void
     */
    public function run()
    {

        $mongoUri = env('MONGO_URI');
        $mongoDatabase = env('MONGO_DATABASE', 'mydatabase');

        $mongoClient = new MongoClient($mongoUri);
        $mongoDB = $mongoClient->selectDatabase($mongoDatabase);
        $churchesCollection = $mongoDB->selectCollection('churches');

        // Ensure `_id` index exists for fast upserts
        $churchesCollection->createIndex(['_id' => 1]);

        // Retrieve all affiliates (tenants)
        $affiliates = Affiliate::all();

        foreach ($affiliates as $affiliate) {
            $affiliate->run(function ($affiliate) use ($churchesCollection) {
                Church::chunk(1000, function ($churches) use ($churchesCollection, $affiliate) {
                    $churchesBulk = [];
                    foreach ($churches as $church) {
                        // Create a unique `_id` using affiliate_id + church_id
                        $mongoId = "affiliate_{$affiliate->id}_church_{$church->id}";

                        $document = [
                            '_id' => $mongoId, // Unique composite key
                            'church_id' => $church->id,
                            'affiliate_id' => $affiliate->id,
                            'name' => $church->name,
                            'address' => $church->address,
                            'location' => [
                                'type' => 'Point',
                                'coordinates' => [
                                    floatval($church->lng),
                                    floatval($church->lat),
                                ],
                            ],
                            'created_at' => $church->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $church->updated_at->format('Y-m-d H:i:s'),
                        ];

                        // Add upsert operation
                        $churchesBulk[] = [
                            'updateOne' => [
                                ['_id' => $mongoId], // Find by unique key
                                ['$set' => $document],
                                ['upsert' => true], // Insert if not exists, update if exists
                            ],
                        ];
                    }

                    // Perform bulk update in MongoDB
                    if (! empty($churchesBulk)) {
                        $churchesCollection->bulkWrite($churchesBulk);
                    }

                });
            });
        }

        $this->command->info('Churches synced into MongoDB successfully.');
    }
}
