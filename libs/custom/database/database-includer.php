<?php
$path = dirname(dirname(__FILE__)) . '/application/application.php';
echo 'Path: ' . $path;
require($path);
use Application\Application;
$app = new Application();
