<?php

namespace App\Enum;

enum ExperienceLevel: string
{
    case JUNIOR = 'junior';
    case INTERMEDIATE = 'intermediate';
    case SENIOR = 'senior';
    case EXPERT = 'expert';

    public function label(): string
    {
        return match ($this) {
            self::JUNIOR => '0 - 1 an',
            self::INTERMEDIATE => '2 - 4 ans',
            self::SENIOR => '5 - 8 ans',
            self::EXPERT => '8+ ans',
        };
    }
}