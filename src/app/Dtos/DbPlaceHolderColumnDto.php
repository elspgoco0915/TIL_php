<?php
declare(strict_types=1);

namespace App\Dtos;

use App\Enums\PdoParamType;
use App\Dtos\Dto;

class DbPlaceHolderColumnDto extends Dto {

    // TODO: 命名
    public string $placeholder;

    /**
     * コンストラクタ
     */
    public function __construct(
        public string $name,
        public mixed $value,
        public PdoParamType $type,
    ){
        $this->placeholder = ":{$this->name}";
    }
}