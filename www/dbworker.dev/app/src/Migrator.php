<?php

    namespace app\src;

    use PDO;

    class Migrator
    {
        private DB $db;
        private TableCreator       $tableCreator;
        private InsertQueryCreator $insertValuesCreator;

        public function __construct(DB $db)
        {
            $this->db = $db;
            $this->tableCreator = new TableCreator();
            $this->insertValuesCreator = new InsertQueryCreator();
        }

        public function setup($shem, $values)
        {
            $this->setShem($shem);
            $this->setValues($values);
        }

        private function setShem($shem)
        {
            $listQuery = [];
            foreach ($shem as $table => $columns) {
                $listQuery[] = $this->tableCreator->getTable($table,$columns);
            }
            $query = implode(PHP_EOL,$listQuery);

            $this->db->exec($query);
        }


        private function setValues($values)
        {


            $listQuery = [];
            foreach ($values as $table => $columns) {
                $listQuery[] = $this->insertValuesCreator->getQuery($table,$columns);
            }
            $massQuery = '';
            $valueList = [];
            foreach ($listQuery as $item) {
                [$query,$prepareValue] =  $item;
                $massQuery .= ' '.$query.' '.PHP_EOL;
                $valueList = array_merge($valueList,$prepareValue);
            }
            $this->db->exec($massQuery,$valueList);
        }
    }