<?php
declare(strict_types=1);

namespace App\Dtos;

class PlayerStatusDto {
    public function __construct(
        public int $userId,
        public int $status, 
    ){}
}