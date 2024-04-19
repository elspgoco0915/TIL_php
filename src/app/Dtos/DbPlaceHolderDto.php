<?php
declare(strict_types=1);

namespace App\Dtos;

use App\Enums\PdoParamType;

class DbPlaceHolderDto {
    public function __construct(
        public string $name,
        public mixed $value,
        public PdoParamType $type,
    ){}
}