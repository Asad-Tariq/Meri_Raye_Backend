<?php

define('HOST', 'localhost');
define('USER_NAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'meri_raye');

// class DB start
class Database {
    private $connection;

    // Constructor
    public function __construct() {
        $this->open_db_connection();
    }

    // Method to create connection with DB
    public function open_db_connection() {
        $this->connection = mysqli_connect(HOST, USER_NAME, PASSWORD, DB_NAME);

        if(mysqli_connect_error()) {
            die('Connection error : ' .mysqli_connect_error());
        }
    }

    // function to execute SQL query
    public function query($sql) {
        $result = $this->connection->query($sql);

        if (!$result) {
            die('Query fails : ' .$sql);
        }

        return $result;
    }

    // function to fetch list of data from the SQL query result
    public function fetch_array($result) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }

            return $result_array;
        }
    }

    // function to fetch a single row of data from the SQL query
    public function fetch_row($result) {
        if ($result->num_row > 0) {
            return $result->fetch_assoc();
        }
    }

    // function to check proper format of data
    public function escape_value($value) {
        return $this->connection->real_escape_string($value);
    }

    // function to close the connection with SQL
    public function close_connection() {
        $this->connection->close();
    }
}

$database = new Database();