<?php
declare(strict_types=1);

namespace App\Enums\trait;
/**
 * BackedEnum用のtrait
 */
trait BackedEnumSelectable 
{
    /**
     * BackedEnumのvalue, nameをキーバリューで返す
     * @return array
     */
    public static function getKeyValue(): array
    {
        return array_combine(
            array_column(self::cases(), 'name'),
            array_column(self::cases(), 'value')
        );
    }
}