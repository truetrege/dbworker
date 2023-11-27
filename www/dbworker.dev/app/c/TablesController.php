<?php

    namespace app\c;

    use app\src\Container;
    use app\src\DeleteQueryCreator;
    use app\src\InsertQueryCreator;
    use app\src\UpdateQueryCreator;

    class TablesController
    {

        public static function index()
        {
            return view('index.html', []);
        }

        public static function all()
        {
            $data  = [];
            $db    = Container::get('db');
            $query = "SHOW TABLES;";

            $listTable = $db->get($query);

            foreach ($listTable as $item) {
                $data[] = $item->Tables_in_tabbble;
            }

            return viewJson($data);
        }

        public static function get()
        {
            $table = request('table');
            $db    = Container::get('db');
            $query = "SELECT * FROM $table WHERE 1;";

            $listTable = $db->get($query, []);

            $headers   = [];
            foreach ($listTable as $rows) {
                foreach ($rows as $key => $element) {
                    $headers[] = $key;
                }
                break;
            }

            $data = [
                'rows'    => $listTable,
                'table'   => $table,
                'headers' => $headers,
            ];

            return viewJson($data);
        }

        public static function update()
        {
            $table  = request('table');
            $values = request('values');
            $where  = request('where');
            $db     = Container::get('db');

            $update = new UpdateQueryCreator();

            [$query, $listValue] = $update->getQuery($table, $values, $where);
            try {
                $db->exec($query, $listValue);
            } catch (\Exception $e) {
                return viewJson(['error' => 'error update']);
            }

            return self::get();
        }

        public static function delete()
        {
            $table = request('table');
            $where = request('where');
            $db    = Container::get('db');

            $update = new DeleteQueryCreator();

            [$query, $listValue] = $update->getQuery($table, $where);
            try {
                $db->exec($query, $listValue);
            } catch (\Exception $e) {
                return viewJson(['error' => 'error delete']);
            }

            return self::get();
        }

        public static function insert()
        {
            $table  = request('table');
            $values = request('values');

            $db     = Container::get('db');
            $insert = new InsertQueryCreator();

            unset($values['id']);
            if ($values['color'] === '') {
                unset($values['color']);
            }

            [$query, $listValue] = $insert->getQuery($table, [$values]);

            try {
                $db->exec($query, $listValue);
            } catch (\Exception $e) {
                return viewJson(['error' => 'error insert']);
            }

            return self::get();
        }

        public static function migration()
        {
            $db = Container::get('db');

            [$shem, $values] = require 'tables.php';

            $migrator = new \app\src\Migrator($db);

            $migrator->setup($shem, $values);

            return viewJson(
                ['success' => true, 'message' => 'migration success']
            );
        }
    }