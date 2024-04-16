<?php
declare(strict_types=1);

namespace App\ExampleClasses;

use App\Enums\PlayerStatus;

class Player {
    
    private PlayerStatus $state;

    /**
     * ゲッター
     * @return int
     */
    public function getState(): int
    {
        return $this->state->value;
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