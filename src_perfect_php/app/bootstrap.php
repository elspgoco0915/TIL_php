<?php
declare(strict_types=1);

// NOTE: feature/#3 perfect php
require __PROJECT_ROOT__  . "/app/Core/ClassLoader.php";

// TODO: オートローダーをuseにする？
$loader = new ClassLoader();
$loader->registerDir(__PROJECT_ROOT__.'/app/Core');
$loader->registerDir(__PROJECT_ROOT__.'/app/Models');
$loader->register();

// TODO: 後で消す
// echo "execute classLoader!!";