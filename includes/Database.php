<?php

class Database {
    public  $host;
    public  $databaseName;
    private $connection;

    function __construct ($host, $databaseName) {
        $this -> host = $host;
        $this -> databaseName = $databaseName;
    }
    function connect ($username, $password){
            $this -> connection = mysqli_connect($this -> host, $username, $password, $this -> databaseName);
    }
    function query ($query) {

    }
}

$database = new Database('localhost', 'wijkrestaurant');
$database -> connect ('root', '');

