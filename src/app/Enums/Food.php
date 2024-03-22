<?php
declare(strict_types=1);

namespace App\Enums;

use App\Enums\trait\BackedEnumSelectable;

// Backed Enum
enum Food : string
{
    // trait
    use BackedEnumSelectable;

    // Backed case
    case Apple = 'りんご';
    case Orange = 'みかん';
    case Carrot = 'にんじん';
    case GreenPepper = 'ピーマン';
    case Other = 'そのほか';

    /**
     * 野菜かどうかを判定
     * @return bool
     */
    public function isVegetable(): bool
    {
        return match ($this) {
            self::Carrot, self::GreenPepper => true,
            default => false, 
        };
    }

    /**
     * casesを取得
     * @param array [Food...] $filters
     * @return array
     */
    // NOTE: Splat Operatorで可変超引数を用いて配列の中身をタイプヒントしている
    //          配列の中身はFoodEnumしか入れないようになる
    public static function getCases(Food ...$filters): array
    {
        // 引数がない場合、全て返す
        if (empty($filters)) return self::cases();
        // 引数がある場合、その条件と一致するcaseだけ取得する
        return array_filter(
            self::cases(),
            fn($case) => in_array($case, $filters)
        );
    }

    /**
     * 野菜を取得
     * @return array
     */
    public static function getVegetables(): array
    {
        $targets = [self::Carrot, self::GreenPepper];
        return self::getCases(...$targets);
    }

    /**
     * 果物を取得
     * @return array
     */
    public static function getFruits(): array
    {
        $targets = [self::Apple, self::Orange];
        return self::getCases(...$targets);
    }

}