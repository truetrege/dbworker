<?php

    namespace app\src;

    use PDO;

    class DB
    {
        private PDO $db;
        public function __construct(PDO $db) {
            $this->db = $db;
        }
        public function exec($query, $values = []){
            $dbQuery = $this->db->prepare($query);
            $dbQuery->execute($values);
        }
        public function get($query,$values=[]){
            $dbQuery = $this->db->prepare($query);
            $dbQuery->execute($values);
            return $dbQuery->fetchAll(PDO::FETCH_OBJ);
        }
    }