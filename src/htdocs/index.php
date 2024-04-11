<?php
declare(strict_types=1);

// TODO: 要修正
const __PROJECT_ROOT__ = "/var/www/html";
require_once "../bootstrap/bootstrap.php";

$controller = $container->get('IndexController');
$controller->index();
// $controller = new App\Controllers\SampleController();
// $controller->index();