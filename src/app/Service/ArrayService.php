<?php
declare(strict_types=1);

namespace App\Service;

use App\Enums\Food;
use App\ExampleClasses\ArrayObjects\ScoreData;

class ArrayService 
{
    public function index()
    {
        echo "<hr>";
        echo "<h2>how to typehint of array</h2>";
        echo "<hr>";

        $scoreData = self::readCsvData("./score_file.csv");
        $highScorePlayer = self::getHighScorePlayer($scoreData);
        echo "ハイスコアは".$highScorePlayer["name"]."さんで".$highScorePlayer["score"]."点でした。\n";
    }

    /**
     * 従来の配列の型付けの書き方
     * @return Food[]
     */
    public function getFoods(): array
    {
        return [
            Food::Apple,
        ];
    }

    /**
     * 旧PSR-5ジェネリクス記法による配列の型付けの書き方
     * ”ArrayObject<{キーの型}, {値の型}>”と書く
     * @see 
     * @return ArrayObject<int, Food>
     */
    public function getFoodsForGenerics(): array
    {
        return [
            Food::Orange,
        ];
    }

    /**
     * array-shapes(Object-like arrays)を使った型付け
     * @see https://psalm.dev/docs/annotating_code/type_syntax/array_types/#object-like-arrays
     * @return array{name: string, age: int, birthday?: DateTimeImmutable}
     */
    public function getMember(): array
    {
        return [
            'name' => 'taro',
            'age'  => 20,
        ];
    }

    /**
     * arrayObjectを用いて、配列の中身を担保する
     * @return ScoreData
     */
    private function readCsvData(string $filename): ScoreData
    {
        // なんらかのCSV加工処理があって、配列にした体
        return new ScoreData([
            [
                "id"    => 1,
                "name"  => "taro",
                "score" => 50,
            ],
            [
                "id"    => 2,
                "name"  => "jiro",
                "score" => 100,
            ],
        ]);
    }

    /**
     * arrayObjectを用いて、引数の配列の中身を担保する
     * 一番scoreが高い配列を返す
     * @param ScoreData
     */
    private function getHighScorePlayer(ScoreData $scoreData): array
    {
        // 一番scoreが高い配列を探して返す体
        return [
            "id"    => 2,
            "name"  => "jiro",
            "score" => 100,
        ];
    }

}
