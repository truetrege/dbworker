<?php

    namespace app\src;

    class DeleteQueryCreator
    {
        public function getQuery($table, $where): array
        {
            $whereNames = [];
            foreach ($where as $name => $value) {
                $whereNames[]    = "`$name` = ?";
                $valuesList[]      = $value;
            }
            $whereBlock = implode(' AND ', $whereNames);
            $query       = "DELETE FROM `$table` WHERE $whereBlock ;";

            return [$query, $valuesList];
        }
    }