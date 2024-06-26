<?php
declare(strict_types=1);

require_once __PROJECT_ROOT__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__PROJECT_ROOT__);
$dotenv->load();

Configure\Configure::getInstance();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('../bootstrap/container.php');
$container = $builder->build();

// DBのインスタンスを呼ぶ関数を作る