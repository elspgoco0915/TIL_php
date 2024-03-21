<?php
declare(strict_types=1);

namespace App\Enums;

use App\Enums\trait\BackedEnumSelectable;

// Backed Enum
enum Food : string
{
    use BackedEnumSelectable;

    // Backed case
    case Apple = 'りんご';
    case Orange = 'みかん';
    case Carrot = 'にんじん';
    case GreenPepper = 'ピーマン';
    case Other = 'そのほか';

    public function isVegetable():bool
    {
        return $this === self::Carrot || $this === self::GreenPepper;
    }
}