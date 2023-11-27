<?php

    namespace app\src;

    class DBConnection
    {
        public static function get(array $config): array
        {
            $driver   = $config['connection']['driver'];
            $host     = $config['connection']['host'];
            $db       = $config['connection']['db'];
            $charset  = $config['connection']['charset'];
            $user     = $config['connection']['user'];
            $password = $config['connection']['password'];

            $dsn      = "$driver:host=$host;dbname=$db;charset=$charset";
            $opt      = [];

            return [$dsn, $user, $password, $opt];
        }
    }