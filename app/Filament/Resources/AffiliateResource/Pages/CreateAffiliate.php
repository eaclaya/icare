<?php

namespace App\Filament\Resources\AffiliateResource\Pages;

use App\Filament\Resources\AffiliateResource;
use App\Models\Member;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;

class CreateAffiliate extends CreateRecord
{
    protected static string $resource = AffiliateResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id'] = strtolower($data['subdomain']);
        $data['domain'] = $data['subdomain'].'.'.env('CENTRAL_DOMAIN');

        return $data;
    }

    protected function afterCreate(): void
    {
        // Add custom logic after creating the Affiliate
        $this->record->domains()->create([
            'domain' => $this->record->domain,
        ]);

        tenancy()->find($this->record->id)->run(function ($tenant) {
            $member = Member::create([
                'first_name' => $this->record->contact_name,
                'last_name' => $this->record->contact_name,
                'email' => $this->record->contact_email,
            ]);

            User::create([
                'name' => $this->record->contact_name,
                'email' => $this->record->contact_email,
                'password' => \Hash::make('password'),
                'member_id' => $member->id,
            ]);

            // Seed the tenant with dummy data
            Artisan::call('tenants:seed', [
                '--tenants' => [$tenant->id]
            ]);
        });
    }
}
