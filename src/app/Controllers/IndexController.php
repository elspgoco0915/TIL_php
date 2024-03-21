<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Enums\AccountStatus;
use App\Enums\Food;

class IndexController
{
    protected $SampleService;

    public function __construct(SampleInterface $SampleService)
    {
        $this->SampleService = $SampleService;
    }


    public function index()
    {
        // feature/#5 enums
        $foods = Food::cases();
        $apple = Food::Apple;
        echo $apple->name;
        echo $apple->value;
        var_dump($apple->isVegetable());

        // tryfrom
        $orange = Food::tryFrom('みかん');
        // enumに存在しない値の場合NULLとなる
        $other = Food::tryfrom('ラーメン') ?? Food::Other;
        echo $orange->value;
        echo $other->value;


        $keyValueArray = Food::getKeyValue();
        var_dump($keyValueArray);
        
        echo "<hr>";
        // PureEnum
        $status = AccountStatus::ACTIVE;
        echo $status->name;
        echo $status->text();
        
        // var_dump(Food::cases());

        var_dump($this->SampleService->index());exit;
    }
}