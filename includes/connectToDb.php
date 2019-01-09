<?php
// met deze 4 variabele maak je connectie met een database
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'wijkrestaurant';

// Stap 1: verbinding maken met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error'. mysqli_connect_error());