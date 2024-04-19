<?php
declare(strict_types=1);

namespace App\Enums;

use PDO;

enum PdoParamType : int
{
    // PDO::PARAM_INT = 1
    case INT = PDO::PARAM_INT;
    // PDO::PARAM_STR = 2
    case STR = PDO::PARAM_STR;
    // PDO::PARAM_BOOL = 5
    case BOOL = PDO::PARAM_BOOL;
}