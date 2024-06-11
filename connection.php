<?php

class Conection{
    private $host = "localhost";
    private $dbname = "Users_db";
    private $user = "root";
    private $password = "";
    private $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->password);
            $this->$conn->exec("set names utf8");

        }catch(PDOException $e){
            echo "Connection Error".$e->getMessage();
        }

        return $conn;
    }
    

}


?>