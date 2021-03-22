<?php

class Database
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;
    private $statement;
    private $dbHandler;
    private $error;
    
    public function __construct() {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //Allows us to write queries
    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    // Bind Int
    public function bindInt($parameter, $value) {
        if (is_int($value)) {
            $type = PDO::PARAM_INT;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    
    // Bind bool
    public function bindBool($parameter, $value) {
        if (is_bool($value)) {
            $type = PDO::PARAM_BOOL;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    
    // Bind string
    public function bindString($parameter, $value) {
        if (is_string($value)) {
            $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    
    // Bind null
    public function bindNull($parameter, $value) {
        if (is_null($value)) {
            $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    
    // Bind dateTime
    public function bindDateTime($parameter, $value) {
        if (is_null($value)) {
            $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
        
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