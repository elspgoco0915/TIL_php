<?php
declare(strict_types=1);

namespace App\Enums;

// Pure Enum
enum AccountStatus
{
    // Pure case
    case ACTIVE;
    case INACTIVE;
    case SUSPENDED;
    case LEAVE;

    public function text(): string
    {
        return match($this) {
            self::ACTIVE    => '有効',
            self::INACTIVE  => '無効',
            self::SUSPENDED => '一時停止',
            self::LEAVE     => '退会'
        };
    }
}