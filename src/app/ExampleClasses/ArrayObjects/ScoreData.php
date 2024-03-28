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

    // TODO: なぜか機能しない
    // // append()禁止
    // public function append($value){
    //     throw new Exception("This object is immutable");
    // }
    // // $arr[0]["name"] = "Taru10"; といった直接の上書きを禁止
    // public function offsetSet($index, $newval){
    //     throw new Exception("This object is immutable");
    // }
    // // unset($arr[0]["name"])などの操作を禁止
    // public function offsetUnset($key){
    //     throw new Exception("This object is immutable");
    // }
    // // 中身を全部差し替えるメソッドの禁止
    // public function exchangeArray($array){
    //     throw new Exception("This object is immutable");
    // }

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