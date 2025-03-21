<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\Member;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // dd($data);

        return $data;
    }

    protected function afterCreate(): void
    {

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
