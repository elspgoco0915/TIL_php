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

    /**
     * 登録する
     */
    public function insert(string $sql): void
    {
        $statement = $this->pdo->prepare($sql);
        // TODO: 動的にinsertできるようにする 型の判定も
        // $statement->bindValue(':test', $name, PDO::PARAM_STR);
        $statement->execute();
    }
}