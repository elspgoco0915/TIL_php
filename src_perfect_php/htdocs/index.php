<?php
declare(strict_types=1);

const __PROJECT_ROOT__ = "/var/www/html";
// require_once "../app/bootstrap.php";
require_once __PROJECT_ROOT__ . "/app/bootstrap.php";

$app = new Application();
$app->run();
exit;