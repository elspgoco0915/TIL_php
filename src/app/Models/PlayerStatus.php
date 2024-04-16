<?php
declare(strict_types=1);

namespace App\Models;

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
    public function insertTest(int $userId, int $status)
    {
        // TODO: userIdカラムの設定を直したら、SQLを直す
        $sql = "INSERT INTO player_statuses(user_id, status) VALUES({$userId}, {$status})";
        $this->insert($sql);
    }

}

