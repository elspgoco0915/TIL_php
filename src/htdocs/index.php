<?php
declare(strict_types=1);

// TODO: 要修正
const __PROJECT_ROOT__ = "/var/www/html";
require_once __PROJECT_ROOT__ . "/vendor/autoload.php";

use App\Controllers\SampleController;

$controller = new SampleController();
$controller->index();