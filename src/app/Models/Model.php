<?php
declare(strict_types=1);

namespace App\Models;

use App\Dtos\DbPlaceHolderDto;
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
     * @param string $table
     * @param DbPlaceHolderDto ...$placeholders
     */
    public function insert(string $table, DbPlaceHolderDto ...$placeholders): void
    {
        // 配列の加工
        // TODO: placeholderという命名、含め全体の命名を変える
        $columns = [];
        foreach ($placeholders as $ph) {
            $columns[] = [
                'name'        => $ph->name,
                'placeholder' => ":{$ph->name}",
                'value'       => $ph->value,
                'type'        => $ph->type->value,
            ];
        }
        $columnStrs = [
            'name' => implode(", ", array_column($columns, 'name')),
            'ph'   => implode(", ", array_column($columns, 'placeholder')),
        ];
        $sql = "INSERT INTO {$table} ({$columnStrs['name']}) VALUES ({$columnStrs['ph']})";
        $statement = $this->pdo->prepare($sql);

        // 値のバインド
        // NOTE: placeholderの数だけbindValueをする
        // ex: `$statement->bindValue(':test', 1, PDO::PARAM_INT);`
        foreach ($columns as $col) {
            $statement->bindValue($col['placeholder'], $col['value'], $col['type']); 
        }

        // 実行
        $statement->execute();
    }
}