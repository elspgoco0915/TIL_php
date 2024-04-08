<?php
declare(strict_types=1);

namespace App\Models;

// TODO: トランザクション周り
use Exception;
use PDO;
use App\Traits\Singleton;

// TODO: app/models以外に適した配置を考える
final class Database 
{
    use Singleton;

    public PDO $pdo;

    private function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        // TODO: 環境変数で呼ぶ
        $this->pdo = new PDO('mysql:host=til_php-db;dbname=til_php', 'til_php', 'til_php-pw', $options);
    }
}