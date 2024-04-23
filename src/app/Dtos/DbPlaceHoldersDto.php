<?php
declare(strict_types=1);

namespace App\Dtos;

use App\Dtos\DbPlaceHolderColumnDto;
use App\Dtos\Dto;
use PDO;

/**
 * DBのプレースホルダーをまとめる
 * DbPlaceHolderColumnDtoのカラムを取りまとめる
 */
class DbPlaceHoldersDto extends Dto 
{
    public string $joinName;
    public string $joinPlaceholder;

    /**
     * コンストラクタ
     */
    public function __construct(
        /** @var array<DbPlaceHolderColumnDto> */
        public array $placeholders
    ){
        // カラム名,プレースホルダーを ”,” 区切りの文字列にして返す
        $this->joinName = implode(", ", array_column($this->toArray($this->placeholders), 'name'));
        $this->joinPlaceholder = implode(", ", array_column($this->toArray($this->placeholders), 'placeholder'));
    }

    /**
     * カラムを返す
     * @return array
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this->placeholders), true);
    }
}