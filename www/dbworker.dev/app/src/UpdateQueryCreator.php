<?php

    namespace app\src;

    class UpdateQueryCreator
    {
        public function getQuery($table, $columns, $where): array
        {
            $valuesList = [];

            $setNames    = [];
            foreach ($columns as $name => $value) {
                $setNames[]    = "`$name` = ?";
                $valuesList[]      = $value;
            }
            $set = implode(',', $setNames);
            $whereNames  = [];
            foreach ($where as $name => $value) {
                $whereNames[]    = "`$name` = ?";
                $valuesList[]      = $value;
            }
            $whereBlock = implode(' AND ',$whereNames);
            $query       = "UPDATE `$table` SET  $set WHERE $whereBlock ;";

            return [$query, $valuesList];
        }
    }