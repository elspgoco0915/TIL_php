<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * 状態異常回復アイテムEnum
 */
// TODO: まずはclassで作ってみる、一旦中断
enum StatusItem: int
{
    // NOTE: 0b = 2進数
    // NOTE: 0x = 16進数

    // 不死鳥の羽 ... 死亡から回復
    case FUSHICHONOO = 0b000001;
    // 毒消し ... 毒から回復
    case DOKUKESHI   = 0b000010;
    // 眠眠打破 ... 眠りから回復
    case MINMINDAHA  = 0b000100;
    // 万能薬 ... 死亡以外の状態上から回復
    case BANNOUYAKU  = 0b111110;
}