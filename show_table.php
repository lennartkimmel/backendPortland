<?php
session_start();
require_once "includes/connect_to_db.php";
require_once "check_login.php";


$query = 'SELECT * FROM reserveringen';
$result = mysqli_query($db, $query)
or die('Error'. mysqli_error($db));

$reservations = [];

while($row = mysqli_fetch_assoc($result)){
    $reservations [] = $row;
}
mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
</head>
<body class="home-body">
<header class="">
    <img src="images/PortlandLogo.png" class="huismerkLogo">
</header>
<table class="striped">
    <thead>
    <tr class="striped">
        <th>ID</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Straatnaam</th>
        <th>Email</th>
        <th>Telefoon</th>
        <th>Bezoekerspas</th>
        <div class="btn1">
            <a class="" href="admin_home.php"><b>Terug naar Home</b></a>
        </div>
    </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
    <!--    <input type="text" class="datepicker">-->
    <?php foreach($reservations as $i => $reservation ) { ?>
        <?php
        //Use the 'modulus' check to define a odd/even class for the table rows
        $rowClass = 'odd';
        if ($i % 2 > 0) {
            $rowClass = 'even';
        }
        $id = $reservation['id'];
        ?>
        <!--        Returns the database values to the appropriate collum's      -->
        <tr class="<?= $rowClass; ?>">
            <td><?= $i + 1; ?>
            <td><?= htmlentities($reservation['Voornaam']); ?></td>
            <td><?= htmlentities($reservation['Achternaam']); ?></td>
            <td><?= htmlentities($reservation['Straatnaam']); ?></td>
            <td><?= htmlentities($reservation['Email']); ?></td>
            <td><?= htmlentities($reservation['Telefoon']); ?></td>
            <td><?= htmlentities($reservation['Bezoekerspas']); ?></td>
            <td><a href="update_from_table.php?id=<?= $id; ?>">Update</a></td>
            <td><a href="delete_from_table.php?id=<?= $id; ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript" src="js/init.js"></script>
</body>
</html>