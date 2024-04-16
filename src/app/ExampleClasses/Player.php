<?php
declare(strict_types=1);

namespace App\ExampleClasses;

use App\Enums\PlayerStatus;
use App\Enums\StatusItem;

// NOTE: ビット演算一覧
// 「&（論理積・AND）」、「|（論理和OR）」「^（排他的論理和XOR)」

class Player {
    
    public int $state = 0b000000;

    /**
     * コンストラクタ
     * @param PlayerStatus $status
     */
    public function __construct(PlayerStatus $status = PlayerStatus::NORMAL)
    {
        $this->setState($status);
    } 

    /**
     * 状態異常の取得
     * @return int
     */
    public function getState(): string
    {
        return decbin($this->state);
    }

    /**
     *　状態異常のセット
     * @param PlayerStatus $status
     * @return void
     */
    public function setState(PlayerStatus $status): void
    {
        /* 
        NOTE:
            ビット和を使用
            右辺左辺のどちらかがセットされていれば、ビットがセットされる
        */
        $this->state = $this->state | $status->value;
    }

    /**
     * 状態異常の回復
     * @param StatusItem $item
     * @return void
     */
    public function removeState(StatusItem $item): void
    {
        /*
        NOTE: 
            ビット演算子のビット積(&)と否定(~)を使用する
            ビット積＝右辺左辺の両方にセットされている場合、ビットがセットされる
            否定=セットされているビットの逆になる　0b111110 -> 0b000001
            ex) 0b111110 & 0b000001 = 0b000000
        */
        $this->state = $this->state & ~$item->value;
    }

}