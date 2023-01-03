<?php

    class Users{

        //properties
        public $name;
        public $email;
        public $password;
        public $user_id;
        public $project_name;
        public $project_description;
        public $project_status;

        private $conn;
        private $users_table;
        private $project_table;

        public function __construct($db)
        {
            $this->conn             =       $db;
            $this->users_table      =       'users';
            $this->project_table    =       'projects';
        }

        public function createUser()
        {
            $sql                    =       'INSERT INTO ' . $this->users_table . ' SET name = ?, email = ?, password = ?';
            $stmt                   =       $this->conn->prepare($sql);
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->email);
            $stmt->bindParam(3, $this->password);
            if($stmt->execute()) {
                return true;
            }
            else{
                return false;
            }

        }

    }

?>