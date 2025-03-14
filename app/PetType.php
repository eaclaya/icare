<?php

namespace App;

enum PetType: string
{
    case DOG = 'dog';

    case CAT = 'cat';

    case BIRD = 'bird';


    public function label(): string
    {
        return match($this)
        {
            self::DOG => 'Dog',
            self::CAT => 'Kitty',
            self::BIRD => 'Bird',
        };
    }

    public static function pluck(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $structure) => [$structure->value => $structure->label()])
            ->toArray();
    }
}
