<?php
declare(strict_types=1);

namespace App\Dtos;

use App\Dtos\DbPlaceHolderColumnDto;
use App\Dtos\Dto;

/**
 * DBのプレースホルダーをまとめる
 * DbPlaceHolderColumnDtoのカラムを取りまとめる
 */
class DbPlaceHoldersDto extends Dto 
{
    // NOTE: プロパティでは可変引数を用いたsplat operatorができなかったのでdocを記載
    /** @var array<DbPlaceHolderColumnDto> */
    public array $columns;
    
    /**
     * コンストラクタ
     */
    public function __construct(
        DbPlaceHolderColumnDto ...$placeholders
    ){
        $this->columns = $placeholders;
    }

    // /**
    //  * カラムを返す
    //  * @return array
    //  */
    // public function toArray(): array
    // {
    //     return json_decode(json_encode($this->columns), true);
    // }

    /**
     * カラム名を”,”区切りの文字列にして返す
     */
    public function getColumnString(): string
    {
        return implode(", ", array_column($this->toArray($this->columns), 'name'));
    }

    /**
     * プレースホルダーを”,”区切りの文字列にして返す
     */
    public function getPlaceHolderString(): string
    {
        return implode(", ", array_column($this->toArray($this->columns), 'placeholder'));
    }
}