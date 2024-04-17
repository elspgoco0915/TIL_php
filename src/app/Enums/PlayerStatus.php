<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * プレイヤー状態異常Enum
 */
// TODO: まずはclassで作ってみる、一旦中断
enum PlayerStatus: int
{
    // NOTE: 0b = 2進数
    // NOTE: 0x = 16進数

    // 通常 ... 2進数=000000 16進数=0
    case NORMAL    = 0b000000;
    // 通常 ... 2進数=000001 16進数=1
    case DEATH     = 0b000001;
    // 通常 ... 2進数=000010 16進数=2
    case POISON    = 0b000010;
    // 通常 ... 2進数=0000100 16進数=4
    case SLEEP     = 0b000100;
    // 通常 ... 2進数=001000 16進数=8
    case PETRIFIED = 0b001000;
    // 通常 ... 2進数=010000 16進数=16
    case CONFUSION = 0b010000;
    // 通常 ... 2進数=100000 16進数=32
    case PARALYSIS = 0b100000;
}