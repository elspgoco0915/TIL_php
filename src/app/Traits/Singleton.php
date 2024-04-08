<?php
declare(strict_types=1);

namespace App\Traits;

use Exception;

/**
 * シングルトンパターン用のトレイト
 */
trait Singleton
{
    // NOTE: trait使用元のclassでコンストラクタをオーバライドして使用する
    protected function __construct(){}

    final public static function getInstance()
    {
        static $instance;
        return $instance ?? $instance = new self;
    }

    final public function __clone()
    {
        throw new Exception("this instance is singleton class.");
    }
}