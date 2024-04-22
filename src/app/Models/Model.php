<?php
declare(strict_types=1);

namespace App\Models;

use App\Dtos\DbPlaceHolderColumnDto;
use App\Dtos\DbPlaceHoldersDto;
use App\Models\Database;
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
     * @param DbPlaceHolderColumnDto $placeholders
     */
    public function insert(string $table, DbPlaceHoldersDto $placeholders): void
    {    
        /*
        TODO: 要修正
            dtoを機能過多にしすぎた
            placeholderの諸々の加工は、DbPlaceHolderColumnDtoではなく、model.phpないで共通関数の方がいいいか？
            もしくは、placeholders内のtoArrayをオーバーライドする、もしくはプロパティ以外の持たせ方を考える
         */

        // 配列の加工
        // TODO: placeholderという命名、含め全体の命名を変える
        // $columns = [];
        // foreach ($placeholders as $ph) {
        //     $columns[] = [
        //         'name'        => $ph->name,
        //         'placeholder' => $ph->placeholder,
        //         'value'       => $ph->value,
        //         'type'        => $ph->type->value,
        //     ];  
        // }
        // var_dump($columns);exit;
        // $columns = $placeholders->toArray();
        // var_dump($columns);exit;

        // $columns = $placeholders->toArray();
        // $columnStrs = [
        //     'name' => implode(", ", array_column($columns, 'name')),
        //     'ph'   => implode(", ", array_column($columns, 'placeholder')),
        // ];
        // $columns = $placeholders->toArray();
        // $columnStrs = [
        //     'name' => $placeholders->getColumnString(),
        //     'ph'   => $placeholders->getPlaceHolderString(),
        // ];

        // var_dump($columnStrs);exit;
        // $sql = "INSERT INTO {$table} ({$columnStrs['name']}) VALUES ({$columnStrs['ph']})";
        $sql = "INSERT INTO {$table} ({$placeholders->getColumnString()}) VALUES ({$placeholders->getPlaceHolderString()})";

        $statement = $this->pdo->prepare($sql);


        // 値のバインド
        // NOTE: placeholderの数だけbindValueをする
        // ex: `$statement->bindValue(':test', 1, PDO::PARAM_INT);`
        $columns = $placeholders->toArray($placeholders->columns);
        foreach ($columns as $col) {
            $statement->bindValue($col['placeholder'], $col['value'], $col['type']); 
        }

        // 実行
        $statement->execute();
    }
}