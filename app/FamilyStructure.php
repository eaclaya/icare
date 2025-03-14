<?php

namespace App;

enum FamilyStructure: string
{
    case NUCLEAR = 'nuclear';
    case SINGLE_MOM = 'single_mom';

    case SINGLE_DAD = 'single_dad';

    case KIN = 'kin';


    public function label(): string
    {
        return match($this)
        {
            self::NUCLEAR => 'Nuclear',
            self::SINGLE_MOM => 'Single Mom',
            self::SINGLE_DAD => 'Single Dad',
            self::KIN => 'Kin',
        };
    }

    public static function pluck(): array
    {
        return collect(self::cases())
        ->mapWithKeys(fn (self $structure) => [$structure->value => $structure->label()])
        ->toArray();
    }
}
