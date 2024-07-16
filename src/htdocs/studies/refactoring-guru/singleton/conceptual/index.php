<?php

namespace RefactoringGuru\Singleton\Conceptual;


/**
 * Singletonクラスは、コンストラクターの代わりとして機能する
 * このクラスの同じインスタンスに何度もアクセスできるように、getInstanceメソッドを定義する
 */
class Singleton
{
    /**
     * Singletonにサブクラスを持たせるため、Singletonのインスタンスは静的フィールド（配列）に格納される
     * この配列内の各項目は、特定のSingletonのサブクラスのインスタンスになる
     */
    private static $instances = [];

    /**
     * Singletonのコンストラクタは new 演算子による、呼び出しを防ぐために、プライベートにします
     * これによって`new Singleton`で呼び出すとエラーになります。
     */
    private function __construct(){}

    /**
     * Singletonはクローンできない、文字列からの復元もできない
     */
    protected function __clone(){}
    public function __wakeup()
    {
        throw new \Exception("cannnot unserialize singleton");
    }

    /**
     * シングルトンインスタンスへのアクセスを制御する静的メソッド
     * 最初の実行では、シングルトンオブジェクトを作成する
     * その後の実行では、静的フィールドに格納されているクライアントの既存のオブジェクトを返す
     * この実装で、各サブクラスのインスタンスを1つだけ保持しながら、シングルトンクラスをサブクラス化できる
     */
    public static function getInstance(): Singleton
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * 最後に、全てのシングルトンは、そのインスタンスで実行できるビジネスロジックを定義する
     */
    public function someBusinessLogic()
    {
        // code...
    }
}

/**
 * クライアントコード
 */
function clientCode()
{
    $test = new Singleton();
    var_dump($test);

    $s1 = Singleton::getInstance();
    $s2 = Singleton::getInstance();
    if ($s1 === $s2) {
        echo "Singletonが機能しています。どちらの変数も同じインスタンスです。";
    } else {
        echo "Singletonが機能していません。どちらの変数も異なるインスタンスです。";
    }
}

clientCode();