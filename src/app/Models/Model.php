<?php
declare(strict_types=1);

namespace App\Models;

use App\Dtos\DbPlaceHolderColumnDto;
use App\Dtos\DbPlaceHoldersDto;
use App\Models\Database;
use App\Enums\PdoParamType;
use PDO;

// TODO:一時的
use App\Dtos\DbPlaceHolderColumnDto as Value;

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
     * @param string $table
     * @param DbPlaceHolderColumnDto[] $placeholders
     */
    public function insert(string $table, DbPlaceHolderColumnDto ...$placeholders): void
    {   
        // 配列の加工
        // TODO: placeholderという命名、含め全体の命名を変える
        $columns = array_map(fn($column) => $column->toArray(), $placeholders);
        $columnStrs = [
            'name' => implode(", ", array_column($columns, 'name')),
            'ph'   => implode(", ", array_column($columns, 'placeholder')),
        ];

        $sql = "INSERT INTO {$table} ({$columnStrs['name']}) VALUES ({$columnStrs['ph']})";
        $statement = $this->pdo->prepare($sql);

        // 値のバインド
        // NOTE: placeholderの数だけbindValueをする
        // ex: `$statement->bindValue(':columnName', 1, PDO::PARAM_INT);`
        foreach ($columns as $col) {
            $statement->bindValue($col['placeholder'], $col['value'], $col['type']); 
        }

        // 実行
        $statement->execute();
    }

    /**
     * 登録する(DTOバージョン)
     */
    public function insertSample(string $table, DbPlaceHoldersDto $placeholders): void
    {
        $sql = "INSERT INTO {$table} ({$placeholders->joinName}) VALUES ({$placeholders->joinPlaceholder})";
        $statement = $this->pdo->prepare($sql);

        // 値のバインド
        // NOTE: placeholderの数だけbindValueをする
        // ex: `$statement->bindValue(':columnName', 1, PDO::PARAM_INT);`
        foreach ($placeholders->toArray() as $col) {
            $statement->bindValue($col['placeholder'], $col['value'], $col['type']); 
        }

        // 実行
        $statement->execute();
    }

}