<?php

namespace App\Enums;

enum BookingObjectEnum
{
    case HOUSE;
    case COTTAGE;
    case APARTMENT;
    case ROOM;
    case SLEEPINGPLACE;
    case TABLE;

    public static function values(): array
    {
        return [
            self::HOUSE->name(),
            self::COTTAGE->name(),
            self::APARTMENT->name(),
            self::ROOM->name(),
            self::SLEEPINGPLACE->name(),
            self::TABLE->name(),
        ];
    }

    public function name(): string
    {
        return match ($this) {
            self::HOUSE => "Дом",
            self::COTTAGE => "Коттедж",
            self::APARTMENT => "Квартира",
            self::ROOM => "Комната",
            self::SLEEPINGPLACE => "Спальное место",
            self::TABLE => "Столик",
        };
    }
}