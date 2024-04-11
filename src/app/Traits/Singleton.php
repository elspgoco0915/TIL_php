<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * シングルトンパターン用のトレイト
 */
trait Singleton
{
    static $instance = null;

    // NOTE: trait使用元のclassでコンストラクタをオーバライドして使用する
    final protected function __construct(){}

    final public static function getInstance()
    {
        return static::$instance ?? static::$instance = new static();
    }

    /**
     * @throws \Exception
     */
    final public function __clone()
    {
        throw new \Exception("This instance is not clone because singleton class.");
    }

    /**
     * @throws \Exception
     */
    public final function __wakeup()
    {
        throw new \Exception('This instance is not unserialize because singleton class');
    }
}