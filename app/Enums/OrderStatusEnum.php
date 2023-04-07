<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public function is($value): bool
    {
        return $this->name == $value || $this == self::tryFrom($value);
    }
}
