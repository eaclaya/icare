<?php

namespace App\Migration\Commands;

use Illuminate\Console\Command;
use App\Migration\Transformers\LegacyAffiliateTransformer;
use App\Migration\Transformers\LegacyChurchTransformer;
use Illuminate\Support\Facades\DB;

class MigrateLegacyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy {affiliateId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to migrate data from the legacy schema to the new one';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $affiliateId = $this->argument('affiliateId');
        if (!$affiliateId) {
            if (!$this->confirm('No affiliate id provided, do you want to migrate all affiliates? (yes/no)')) {
                $this->info('Migration canceled');
                return;
            }
        }

        /* $this->migrateAffiliate($affiliateId); */


        $this->migrateChurches($affiliateId);

        // the overall process is:
        // - fetch 'domain' specific data, (affiliate), then dispatch a job that will transform and insert the data.

        // affiliates:
        // - ltp_affiliates
        // - ltp_affiliates_params
        // - staff users of that affiliate
        // - churches associated with that affiliates


        // fetch from ltp_affiliates table from the legacy db connection.
        // fetch from the ltp_affiliates_params table with the given id
        // dispatch a job with the resulting data to transform it in the new schema compatible format and inserts it.

        // then..
        // fetch the churches associated with this affiliate (from the assignments table.)
        // fetch the churches details from the ltp_churches table
        //
    }

    /**
     * migrateAffiliate
     *
     * @param mixed $affiliateId
     */
    private function migrateAffiliate($affiliateId): void
    {
        $this->info($affiliateId ? 'Migrating affiliate with id: ' . $affiliateId : 'Migrating all affiliates');

        // fetch the affiliate data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_affiliates');

        $affiliateData = $affiliateId
            ? $query->where('id_affiliate', $affiliateId)->get()->map(fn ($aff) => (array) $aff)->toArray()
            : $query->get()->map(fn ($aff) => (array) $aff)->toArray();

        $transformedData = [];
        foreach ($affiliateData as $affiliate) {
            $transformedData[] = LegacyAffiliateTransformer::transform($affiliate);
        }

        //Affiliate::insert($transformedData);
        print_r($transformedData);
    }

    private function migrateChurches($affiliateId): void
    {
        $this->info( 'Migrating churches from affiliate id: ' . $affiliateId);

        // fetch the data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_assignments as a')
            ->join('ltp_churches as c', function ($join) {
                $join->on('a.id_church', '=', 'c.id_church')
                    ->where('c.state', '>', 0);
            })
            ->where('a.id_affiliate', $affiliateId)
            ->where('a.state', '>', 0)
            ->select('c.*')
            ->groupBy('c.id_church');

        $churchesData = $query->get()->map(fn ($data) => (array) $data);

        $transformedData = [];
        foreach ($churchesData as $church) {
            $transformedData[] = LegacyChurchTransformer::transform($church);
        }

        //Churches::insert($transformedData);
        print_r($transformedData);
    }
}
