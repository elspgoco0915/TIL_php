<?php
declare(strict_types=1);

namespace App\ExampleClasses;

use App\Enums\PlayerStatus;

class Player {
    
    public int $state = 0;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->setState(PlayerStatus::NORMAL->value);
    } 

    /**
     * ゲッター
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * セッター
     * @return void
     */
    public function setState($value): void
    {
        $this->state = $value;
    }
}