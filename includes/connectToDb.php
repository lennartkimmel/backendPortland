<?php
// met deze 4 variabele maak je connectie met een database
//$host       = 'localhost';
//$username   = 'root';
//$password   = '';
//$database   = 'wijkrestaurant';
//
//// Stap 1: verbinding maken met de database
//$db = mysqli_connect($host, $username, $password, $database)
//or die('Error'. mysqli_connect_error());

$db = array (
    'host' => 'localhost',
    'dbname' => 'wijkrestaurant',
    'user' => 'root',
    'pass' => ''
);


try
{
    $db = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'], $db['user'], $db['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");
}
catch(PDOException $e)
{
    $sMsg = '<p>
            Line: '.$e->getLine().'<br />
            File: '.$e->getFile().'<br />
            Message: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);
}