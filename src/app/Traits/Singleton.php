<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * シングルトンパターン用のトレイト
 */
trait Singleton
{
    // TODO: プロパティの$instanceがないのになぜ機能するか理解する

    // NOTE: trait使用元のclassでコンストラクタをオーバライドして使用する
    protected function __construct(){}

    final public static function getInstance()
    {
        static $instance;
        return $instance ?? $instance = new self;
    }

    // TODO: /src/config/Configure.phpの旧メソッドと比較する
    // public static function Instance()
    // {
    //     if (empty(self::$instance)) {
    //         self::$instance = new Configure();
    //     }
    //     return self::$instance;
    // }

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