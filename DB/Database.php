<?php

    class Database {

        private $hostname;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function connect()
        {
            $this->hostname     =   'localhost';
            $this->dbname       =   'jwt';
            $this->username     =   'root';
            $this->password     =   '';

            try {
                    $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                }catch(PDOException $e){
                    echo 'Connection Failed: ' . $e->getMessage();
            }
        }

    } //End Database class

?>