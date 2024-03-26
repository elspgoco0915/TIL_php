<?php

namespace App\Dtos;

class UserDto {
    public function __construct(
        public int $id,
        public string $name, 
        public bool $isSomething = false
    ){}
}