<?php

namespace App\Enums;

enum AvailableEnum
{
    case AVAILABLE;
    case RESERVED;
    case BUSY;
    case CANCELLED;

    public static function values(): array
    {
        return [
            self::AVAILABLE->name(),
            self::RESERVED->name(),
            self::BUSY->name(),
            self::CANCELLED->name(),
        ];
    }

    public function name(): string
    {
        return match ($this) {
            self::AVAILABLE => "Свободно",
            self::RESERVED => "Зарезервировано",
            self::BUSY => "Занято",
            self::CANCELLED => "Ошибка",
        };
    }
}