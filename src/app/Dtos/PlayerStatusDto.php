<?php
declare(strict_types=1);

namespace App\Dtos;

/**
 * NOTE: 元となるSQL
 * docker-compose 実行時に自動的にSQLを実行するようにする 
        CREATE TABLE user_statuses (
            user_id INT UNSIGNED PRIMARY KEY,
            status TINYINT UNSIGNED DEFAULT 0
        );
 * 
 */

class PlayerStatusDto {
    public function __construct(
        public int $userId,
        public int $status, 
    ){}
}