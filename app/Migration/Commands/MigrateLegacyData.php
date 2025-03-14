<?php

namespace App\Migration\Commands;

use Illuminate\Console\Command;
use App\Migration\Transformers\LegacyAffiliateTransformer;
use App\Migration\Transformers\LegacyChurchTransformer;
use App\Migration\Transformers\LegacyUserTransformer;
use App\Migration\Transformers\LegacyFamilyTransformer;
use App\Migration\Transformers\LegacyCommunityTransformer;
use App\Migration\Transformers\LegacyEventTransformer;
use Illuminate\Support\Facades\DB;

class MigrateLegacyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy {affiliateId?} {--debug}';

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

        try {
            $this->migrateAffiliate($affiliateId);
            $this->migrateAffiliateStaff($affiliateId);
            $this->migrateAffiliateChurches($affiliateId);
            $this->migrateAffiliateFamilies($affiliateId);
            $this->migrateAffiliateCommunities($affiliateId);
            $this->migrateAffiliateEvents($affiliateId);

            // ... and so on
        } catch (\Exception $e) {
            $this->error('An error occurred while migrating the data: ' . $e->getMessage());
        }
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

        $query = $affiliateId
            ? $query->where('id_affiliate', $affiliateId)
            : $query;

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to fetch the affiliate: ' . $query->toRawSql());
        }

        $affiliateData = $query->get()->map(fn ($aff) => (array) $aff)->toArray();

        $transformedData = [];
        foreach ($affiliateData as $affiliate) {
            $transformedData[] = LegacyAffiliateTransformer::transform($affiliate);
        }

        //Affiliate::insert($transformedData);
        /* print_r($transformedData); */
        $this->info('Found ' . count($transformedData) . ' affiliates');
    }

    private function migrateAffiliateStaff($affiliateId): void
    {
        $this->info('Migrating people directly associated with affiliate id: ' . $affiliateId);

        // fetch the data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_assignments as a')
            ->join('ltp_people as p', function ($join) {
                $join->on('a.id_people', '=', 'p.id_people')
                    ->where('p.state', '>', 0);
            })
            ->where('a.id_affiliate', $affiliateId)
            ->whereIn('a.assignment_type', ['people_to_affiliate', 'people_to_staff'])
            ->where('a.state', '>', 0)
            ->select('p.*')
            ->groupBy('p.id_people');

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to get the people directly associated with the affiliate: ' . $query->toRawSql());
        }

        $staffUsersData = $query->get()->map(fn ($data) => (array) $data);

        $transformedData = [];
        foreach ($staffUsersData as $user) {
            $transformedData[] = LegacyUserTransformer::transform($user);
        }

        //Users::insert($transformedData);
        /* print_r($transformedData); */

        $this->info('Found ' . count($transformedData) . ' staff users');
    }

    private function migrateAffiliateChurches($affiliateId): void
    {
        $this->info('Migrating churches from affiliate id: ' . $affiliateId);

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

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to get the churches directly associated with the affiliate: ' . $query->toRawSql());
        }

        $churchesData = $query->get()->map(fn ($data) => (array) $data);

        $transformedData = [];
        foreach ($churchesData as $church) {
            $transformedData[] = LegacyChurchTransformer::transform($church);
        }

        //Churches::insert($transformedData);
        /* print_r($transformedData); */
        $this->info('Found ' . count($transformedData) . ' churches');
    }

    private function migrateAffiliateFamilies($affiliateId): void
    {
        $this->info('Migrating families from affiliate id: ' . $affiliateId);

        // fetch the data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_assignments as a')
            ->join('ltp_families as f', function ($join) {
                $join->on('a.id_family', '=', 'f.id_family')
                    ->where('f.state', '>', 0);
            })
            ->where('a.id_affiliate', $affiliateId)
            ->where('a.state', '>', 0)
            ->select('f.*')
            ->groupBy('f.id_family');

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to get the families directly associated with the affiliate: ' . $query->toRawSql());
        }

        $familiesData = $query->get()->map(fn ($data) => (array) $data);

        /* print_r($familiesData); */

        $transformedData = [];
        foreach ($familiesData as $family) {
            $transformedData[] = LegacyFamilyTransformer::transform($family);
        }

        //Family::insert($transformedData);
        /* print_r($transformedData); */
        $this->info('Found ' . count($transformedData) . ' families');
    }

    private function migrateAffiliateCommunities($affiliateId): void
    {
        $this->info('Migrating communities from affiliate id: ' . $affiliateId);

        // fetch the data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_assignments as a')
            ->join('ltp_communities as c', function ($join) {
                $join->on('a.id_community', '=', 'c.id_community')
                    ->where('c.state', '>', 0);
            })
            ->where('a.id_affiliate', $affiliateId)
            ->where('a.state', '>', 0)
            ->where('a.id_community', '>', 0)
            ->select('c.*')
            ->groupBy('c.id_community');

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to get the communities associated with the affiliate: ' . $query->toRawSql());
        }

        $communitiesData = $query->get()->map(fn ($data) => (array) $data);

        /* print_r($communitiesData); */

        $transformedData = [];
        foreach ($communitiesData as $community) {
            $transformedData[] = LegacyCommunityTransformer::transform($community);
        }

        //Churches::insert($transformedData);
        /* print_r($transformedData); */
        $this->info('Found ' . count($transformedData) . ' communities');
    }

    private function migrateAffiliateEvents($affiliateId): void
    {
        $this->info('Migrating events from affiliate id: ' . $affiliateId);

        // fetch the data from the legacy db connection.
        $query = DB::connection('legacy')->table('ltp_assignments as a')
            ->join('ltp_events as e', function ($join) {
                $join->on('a.id_event', '=', 'e.id_event')
                    ->where('e.state', '>', 0);
            })
            ->where('a.id_affiliate', $affiliateId)
            ->where('a.state', '>', 0)
            ->where('a.id_event', '>', 0)
            ->select('e.*')
            ->groupBy('e.id_event');

        if ($this->option('debug')) {
            $this->info('[DEBUG] Query used to get the events associated with the affiliate: ' . $query->toRawSql());
        }

        $eventsData = $query->get()->map(fn ($data) => (array) $data);
        /* print_r($eventsData); */

        $transformedData = [];
        foreach ($eventsData as $event) {
            $transformedData[] = LegacyEventTransformer::transform($event);
        }

        //Events::insert($transformedData);
        /* print_r($transformedData); */
        $this->info('Found ' . count($transformedData) . ' events');
    }
}
