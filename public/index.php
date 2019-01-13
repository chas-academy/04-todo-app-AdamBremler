<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/..';

require $root . '/vendor/autoload.php';

Router::load($root . '/src/routes.php')->direct(getUri(), getMethod());

?>