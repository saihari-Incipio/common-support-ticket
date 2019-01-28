<?php

session_start();

include_once 'config.php';
include_once 'App.php';
include_once 'lib/Router.php';

$app = new App();
$router = new Router();
$app->initialize($router);
$app->run();
?>