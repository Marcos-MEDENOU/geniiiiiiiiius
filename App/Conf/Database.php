<?php

class Database {
    public function connect() {
        /**
         * $DB_HOST 
         */
        $DB_HOST = "localhost";
        /**
         * $DB_NAME
         */
        $DB_NAME = "blog";
        /**
         * $USERNAME
         */
        $USERNAME = "root";
        /**
         * $PASSWORD
         */
        $PASSWORD = "";
        $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
        try {
            /**
             * connexion à la bdd du nom de freek
             */
            $conn = new PDO($dsn, $USERNAME, $PASSWORD);
            return $conn;
        } catch(PDOException $e) {
            die('Erreur connexion:'.$e->getMessage());
        }
    }
}