<?php

use App\Kernel\App;

require_once $_SERVER['DOCUMENT_ROOT'] . "/src/core/funcs.php";

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$app = new App();

$app->run();