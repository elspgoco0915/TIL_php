<?php
declare(strict_types=1);

namespace Configure;

/**
 * 環境設定クラス
 * シングルトンで定義されている
 */
class Configure 
{
    private static $instance;
    private static $config;

    private function __construct()
    {
        self::$config['app'] = include "app.php";
    }

    public static function Instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Configure();
        }
        return self::$instance;
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

    /**
     * @throws \Exception
     */
    public final function __clone()
    {
        throw new \Exception('This Instance is Not Clone');
    }

    /**
     * @throws \Exception
     */
    public final function __wakeup()
    {
        throw new \Exception('This Instance is Not unserialize');
    }
}