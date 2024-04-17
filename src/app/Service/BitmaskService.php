<?php
declare(strict_types=1);

namespace App\Service;

use App\ExampleClasses\Player;
use App\Enums\PlayerStatus;
use App\Enums\StatusItem;
use App\Models\PlayerStatus as PlayerStatusModel;

class BitMaskService {

    public function index()
    {
        echo "<hr>";
        echo "<h1>bitmask</h1>";

        // DB疎通確認
        $model = new PlayerStatusModel();
        $array = $model->getAll();
        $endUserId = end($array)['user_id'];
        $model->insertTest($endUserId+1, 0);
        echo "<pre>";
        var_dump($model->getAll());
        echo "</pre>";

        // 初期状態は状態異常なし
        $player = new Player();
        echo $player->getState()."<br>";

        $player->setState(PlayerStatus::POISON);
        echo $player->getState()."<br>";

        $player->setState(PlayerStatus::PARALYSIS);
        echo $player->getState()."<br>";

        $player->setState(PlayerStatus::CONFUSION);
        echo $player->getState()."<br>";

        $player->removeState(StatusItem::BANNOUYAKU);
        echo $player->getState()."<br>";

        echo "<hr>";
        exit;

    }
}
