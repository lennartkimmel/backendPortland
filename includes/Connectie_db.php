<?php
//Require DB settings with connection variable
require_once "connect_to_db.php";

//Get the result set from the database with a SQL query
$query = "SELECT * FROM reserveringen";

$result = mysqli_query($db, $query)
or die('Error'. mysqli_error($db));

//Loop through the result to create a custom array
$reservation = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservation[] = $row;
}

//Close connection
mysqli_close($db);
