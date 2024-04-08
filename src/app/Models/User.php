<?php
declare(strict_types=1);

namespace App\Models;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * TODO: 戻り値をUserDtoにしたい
     */
    public function getUsers(): array
    {
        $sql = "SELECT * FROM users;";
        return $this->fetchAll($sql);
    }
}

