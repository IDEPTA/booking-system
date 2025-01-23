<?php

namespace App\Enums;

enum BookingTypeEnum
{
    case ACCOMMODATION;
    case SERVICE;
    case DINING;
    case LEISURE;
    case CONSULTATION;
    case WORKSPACE;

    public static function values(): array
    {
        return [
            self::ACCOMMODATION->name(),
            self::SERVICE->name(),
            self::DINING->name(),
            self::LEISURE->name(),
            self::CONSULTATION->name(),
            self::WORKSPACE->name()
        ];
    }

    public function name(): string
    {
        return match ($this) {
            self::ACCOMMODATION => "Жилье",
            self::SERVICE => "Услуга",
            self::DINING => "Питание",
            self::LEISURE => "Досуг",
            self::CONSULTATION => "Консультация",
            self::WORKSPACE => "Рабочее место",
        };
    }
}