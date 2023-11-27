<?php

    namespace app\src;

    class TableCreator
    {
        public function getTable($table, $columns): string
        {
            $query = "CREATE TABLE IF NOT EXISTS `$table` (".PHP_EOL;

            $columnList = $this->getColumns($columns);
            $primary    = $this->getPrimary($columns);

            if ($primary) {
                $columnList[] = $primary;
            }

            $query .= implode(','.PHP_EOL, $columnList);
            $query .= ")".PHP_EOL;
            $query .= 'AUTO_INCREMENT=1'.PHP_EOL;
            $query .= ";".PHP_EOL;


            return $query;
        }

        private function getColumns($columns): array
        {
            $columnList = [];
            foreach ($columns as $column => $set) {
                $columnList [] = $this->columnCreator($column, $set);
            }

            return $columnList;
        }

        private function getPrimary($columns): ?string
        {
            foreach ($columns as $column => $set) {
                if (isset($set['primary']) && $set['primary'] === true) {
                    return "PRIMARY KEY (`$column`) USING BTREE".PHP_EOL;
                };
            }

            return null;
        }

        private function columnCreator($name, $settings): string
        {
            $type          = $settings['type'] ?? null;
            $length        = $settings['length'] ?? null;
            $nullable      = $settings['nullable'] ?? null;
            $autoincrement = $settings['autoincrement'] ?? null;

            if ($length) {
                $type .= "($length)";
            }

            if ($nullable) {
                $nullable = 'NULL';
            } else {
                $nullable = 'NOT NULL';
            }

            if (!isset($settings['default'])) {
                $default = '';
            } elseif ($settings['default'] == null) {
                $default = "DEFAULT NULL";
            } else {
                $default = "DEFAULT '{$settings['default']}'";
            }
            if ($autoincrement) {
                $autoincrement = 'AUTO_INCREMENT';
            } else {
                $autoincrement = '';
            }


            return "`$name` $type $nullable $default $autoincrement";
        }
    }