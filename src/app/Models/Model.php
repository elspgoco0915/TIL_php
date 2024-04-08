<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Database;
use PDO;

abstract class Model {

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }

    /**
     * 全件取得する
     * @param string $sql
     * @return array
     */
    public function fetchAll(string $sql): array
    {
        $statement = $this->pdo->query($sql);
        $rows = $statement->fetchAll();
        return $rows;
    }
}