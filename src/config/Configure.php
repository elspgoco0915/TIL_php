<?php
declare(strict_types=1);

// TODO: Configでいい気もする
namespace Configure;

use App\Traits\Singleton;

/**
 * 環境変数設定
 * シングルトンパターンで呼び出している
 */
class Configure 
{
    use Singleton;

    private static array $const = [];

    /**
     * コンストラクタ
     * "./{$fileName}.php"の定数群を読み込む
     */
    private function __construct()
    {
        $fileName = "app";
        self::$const[$fileName] = include "{$fileName}.php";
    }

    /**
     * 環境変数取得
     * 例) `Configure::read('app.sample.env');` で呼び出す
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
        $result = self::$const;
        foreach ($keys as $key => $val) {
            $result = $result[$val];
        }
        return $result;
    }
}