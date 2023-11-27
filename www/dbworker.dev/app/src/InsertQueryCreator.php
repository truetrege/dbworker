<?php

    namespace app\src;

    class InsertQueryCreator
    {
        public function getQuery($table,$columns){

            $insert = [];
            $valuesList = [];

            foreach($columns as  $column){
                $query = "INSERT INTO `$table` ";
                $valuesQueryList = [];
                $columnsNames = [];
                foreach ($column as $name=>$value){
                    $columnsNames[] = "`$name`";
                    $valuesQueryList[] = '?';
                    $valuesList[] = $value;
                }
                $columnBlock = implode(',',$columnsNames);
                $valuesBlock = implode(',',$valuesQueryList);
                $query .= '('.$columnBlock.') VALUES ('.$valuesBlock.');';
                $insert[] = $query;
            }
            $insertString = implode(PHP_EOL,$insert);
              return [$insertString,$valuesList];
        }
    }