<?php

namespace App\Enum;

enum PropertyTypeEnum: string
{
    case House = 'house';
    case Apartment = 'apartment';
    case Condo = 'condo';
    case Townhouse = 'townhouse';
    case Land = 'land';

    public function label(): string
    {
        return match ($this) {
            self::House => 'House',
            self::Apartment => 'Apartment',
            self::Condo => 'Condo',
            self::Townhouse => 'Townhouse',
            self::Land => 'Land',
        };
    }

    public static function getLabelFromValue(string $value): string
    {
        return match ($value) {
            'house' => 'House',
            'apartment' => 'Apartment',
            'condo' => 'Condo',
            'townhouse' => 'Townhouse',
            'land' => 'Land',
            default => 'Unknown',
        };
    }
}
