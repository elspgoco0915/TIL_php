<?php
declare(strict_types=1);

namespace App\Models;

// TODO: トランザクション周り
use Exception;
use PDO;
use App\Traits\Singleton;
use Configure\Configure;

// TODO: app/models以外に適した配置を考える
// TODO: extends PDOのパターンでもできる？
final class Database 
{
    use Singleton;

    public PDO $pdo;

    private function __construct()
    {
        // DB設定
        $host = Configure::read('app.mysql.host');
        $db = Configure::read('app.mysql.db');
        $user = Configure::read('app.mysql.user');
        $pw = Configure::read('app.mysql.pw');
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        // PDOのインスタンス作成
        $this->pdo = new PDO("mysql:host={$host};dbname={$db}", "{$user}", "{$pw}", $options);
    }

    // TODO: pdoのデストラクタを作って
    // TODO: insertのbindValueをこっちに逃す
    // TODO: prepare, executeなどもこっちに内包する？

}