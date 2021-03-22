<?php

class Database
{
    private $serverName = DB_HOST;
    private $userName = DB_USER;
    private $password = DB_PASS;
    private $dbName = DB_;
    private $errorMess;
    
    
    public function __construct() {
        //Setup PDO DNS.
        $conn = new PDO("'mysql:host=' . $this->dbServerName . ';dbname=' . $this->dbName");
        //Setup PDO Options.
        $pdoOptions = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        //Establish DB Connection.
        try {
            $this->pdo_DB = new PDO($conn, $this->$userName, $this->$password, $pdoOptions);
        } catch (PDOException $e) {
            $this->$errorMess = ($e->getMessage());
            echo $errorMess;
        }
    }   

    //Allows us to write queries
    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    //Bind values
    public function bind($parameter, $value, $type = null) {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    //Execute the prepared statement
    public function execute() {
        return $this->statement->execute();
    }

    //Return an array
    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    //Return a specific row as an object
    public function single() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    //Get's the row count
    public function rowCount() {
        return $this->statement->rowCount();
    }
}