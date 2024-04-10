<?php
declare(strict_types=1);

// TODO: Configでいい気もする
namespace Configure;

use App\Traits\Singleton;

/**
 * 環境設定クラス
 * シングルトンパターンで呼び出す
 */
class Configure 
{
    use Singleton;

    private static $config;

    private function __construct()
    {
        self::$config['app'] = include "app.php";
    }

    /**
     * @param string $keys
     * @return mixed
     * @throws \Exception
     */
    public static function read(string $keys)
    {
        if ($keys === '') {
            throw new \Exception('Argument 1 passed to Configure\Configure::read() must be Not Blank.');
        }
        
        $keys = explode('.', $keys);
        $result = self::$config;
        foreach ($keys as $key => $val) {
            $result = $result[$val];
        }
        return $result;
    }
}