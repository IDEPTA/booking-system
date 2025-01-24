<?php

namespace App\Enums;

enum PaymentStatusEnum
{
    case PENDING;
    case PROCESSING;
    case COMPLETED;
    case FAILED;
    case REFUNDED;
    case CANCELLED;

    public static function values(): array
    {
        return [
            self::PENDING->name(),
            self::PROCESSING->name(),
            self::COMPLETED->name(),
            self::FAILED->name(),
            self::REFUNDED->name(),
            self::CANCELLED->name(),
        ];
    }

    public function name(): string
    {
        return match ($this) {
            self::PENDING => "Ожидает обработки",
            self::PROCESSING => "Обрабатывается",
            self::COMPLETED => "Завершен",
            self::FAILED => "Ошибка",
            self::REFUNDED => "Возвращен",
            self::CANCELLED => "Отменен",
        };
    }
}