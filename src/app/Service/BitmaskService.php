<?php
declare(strict_types=1);

namespace App\Service;

use App\ExampleClasses\Player;
use App\Enums\PlayerStatus;
use App\Enums\StatusItem;

class BitMaskService {

    public function index()
    {
        echo "<hr>";
        echo "<h1>bitmask</h1>";

        // 初期状態は状態異常なし
        $player = new Player();
        echo decbin($player->getState())."<br>";
        
        // 毒を追加
        $player->setState(PlayerStatus::POISON->value);
        echo decbin($player->getState())."<br>";
        // 麻痺を追加したいが、毒がなくなり上書きされてしまう
        $player->setState(PlayerStatus::PARALYSIS->value);
        echo decbin($player->getState())."<br>";

        // ビット演算子を使用することで、解決
        $player->setState(PlayerStatus::POISON->value);
        // ビット和
        $player->setState($player->state | PlayerStatus::PARALYSIS->value);
        echo decbin($player->getState())."<br>";
        // さらに追加することで、「毒、まひ、混乱」が上書きされず追加できた。
        $player->setState($player->state | PlayerStatus::CONFUSION->value);
        echo decbin($player->getState())."<br>";
        
        // 回復
        // ビット演算子のビット積(&)と否定(~)を使用する
        // ビット積＝右辺左辺の両方にセットされている場合、ビットがセットされる
        // 否定=セットされているビットの逆になる　0b111110 -> 0b000001
        // 0b111110 & 0b000001 = 0b000000
        $player->setState($player->state & ~StatusItem::BANNOUYAKU);
        // よって、状態異常が回復する
        echo decbin($player->getState())."<br>";
    
        echo "<hr>";
        exit;
        // memo
        // 「&（論理積・AND）」、「|（論理和OR）」「^（排他的論理和XOR)」を

    }
}
