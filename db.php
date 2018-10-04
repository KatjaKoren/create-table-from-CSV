<?php
class DataBase
{
    const SERVER_NAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DBNAME = "dbvehicles";

    function dbConnect()
    {
        $conn = new mysqli(self::SERVER_NAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn->connect_error) {
           die("Error connecting to the database: " . $conn->connect_error);
        } 
        return $conn; 
    }
}

?>