<?php

namespace App\Models;

use Silber\Bouncer\Database\Role as Model;

class Role extends Model
{
    public static function roleAbilitiesSchema(): array
    {
        return [
            Team::class => [
                'Volunteer' => ['create', 'view'],
                'Team Leader' => ['create', 'view', 'edit']
            ],
            Group::class => [
                'Parent' => ['create', 'view', 'edit', 'delete'],
                'Children' => ['view']
            ],
        ];
    }
}
