<?php

    require_once 'vendor/autoload.php';
    require_once 'app/bootstrap.php';
    use app\src\Container;

    $db = Container::get('db');

    [$shem, $values] = require 'tables.php';

    $migrator = new \app\src\Migrator($db);

    $migrator->setup($shem, $values);