<?php


use Application\Application;

require(__DIR__.'/application.php');

$app = new Application();

require($_SERVER['DOCUMENT_ROOT'].'/../app/routes.php');

return $app;