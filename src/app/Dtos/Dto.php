<?php
declare(strict_types=1);

namespace App\Dtos;

/**
 * DataTransferObject
 */
abstract class Dto 
{
    /**
     * 連想配列にして返す
     * @param mixed $property
     * @return array
     */
    public function toArray($property = null): array
    {
        if (isset($propety)) $property = $this;
        return json_decode(json_encode($property), true);
    }
}