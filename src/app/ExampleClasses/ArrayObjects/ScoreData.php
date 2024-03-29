<?php
declare(strict_types=1);

namespace App\ExampleClasses\ArrayObjects;

use ArrayObject;
use ArrayIterator;
use Exception;

class ScoreData extends ArrayObject
{
    private array $expectedKeys;

    public function __construct(array $array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
    {
        $this->expectedKeys = ['id', 'name', 'score'];
        self::__checkFormat($array);
        parent::__construct($array, $flags, $iteratorClass);
    }

    private function __checkFormat(array $array): void
    {
        sort($this->expectedKeys);

        foreach ($array as $player) {
            $keys = array_keys($player);
            sort($keys);
            if ($keys !== $this->expectedKeys) {
                $keysText = implode(", ", $this->expectedKeys); 
                throw new Exception("Type mismatch. Each rows must have {$keysText}.");
            }
        }
    }
}