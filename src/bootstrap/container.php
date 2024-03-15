<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    'SampleService' => factory(function (ContainerInterface $c) {
        return new App\Service\SampleAService();
        // return new App\Service\SampleBService();
    }),
    'IndexController' => factory(function (ContainerInterface $c) {
        return new App\Controllers\IndexController($c->get('SampleService'));
    }),
];