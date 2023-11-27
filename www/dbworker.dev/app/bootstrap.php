<?php

    use app\src\Container;
    use app\src\DBConnection;

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    $config = require 'config.php';
    $DB_PDO = new PDO(...DBConnection::get($config));

    $DB = new \app\src\DB($DB_PDO);

    Container::set('db',$DB);
