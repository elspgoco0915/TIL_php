<?php
declare(strict_types=1);

// TODO: 要修正
const __PROJECT_ROOT__ = "/var/www/html";
require_once "../bootstrap/bootstrap.php";

use App\Controllers\SampleController;

$controller = new SampleController();
$controller->index();