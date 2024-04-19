<?php
declare(strict_types=1);

namespace App\Models;

use App\Dtos\DbPlaceHolderDto as Value;
use App\Enums\PdoParamType;

/**
 * NOTE: 元となるSQL
 * docker-compose 実行時に自動的にSQLを実行するようにする 
        CREATE TABLE player_statuses (
            user_id INT UNSIGNED PRIMARY KEY,
            status TINYINT UNSIGNED DEFAULT 0
        );
 * 
 */
class PlayerStatus extends Model
{
    // TODO: $db名を持たせる
    protected string $table = 'player_statuses';

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * TODO: 戻り値をDtoにしたい
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM player_statuses;";
        return $this->fetchAll($sql);
    }

    /**
     * 挿入テスト
     * @param int $userId
     * @param int $status
     */
    // TODO: 関数名を変える
    public function insertTest(int $userId, int $status)
    {
        // TODO: placeholderという命名、含め全体の命名を変える
        $placeholders = [
            new Value(name: 'user_id', value: $userId, type: PdoParamType::INT),
            new Value(name: 'status', value: $status, type: PdoParamType::INT),
        ];
        $this->insert($this->table, ...$placeholders);
    }

}

