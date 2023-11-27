<?php


    //error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once 'vendor/autoload.php';
    require_once 'app/bootstrap.php';

    [$controller, $action, $arguments] = routeMatcher();

    $response = $controller::$action($arguments);

    send($response);

    die();
