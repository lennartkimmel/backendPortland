<?php
session_start();
require_once "includes/connectToDb.php";
require_once "checkLogin.php";


$query = 'SELECT * FROM reserveringen';
$result = mysqli_query($db, $query)
or die('Error'. mysqli_error($db));

$gemaakteReserveringen = [];

while($row = mysqli_fetch_assoc($result)){
    $gemaakteReserveringen [] = $row;
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
            <a class="" href="adminHome.php"><b>Terug naar Home</b></a>
        </div>
    </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
<!--    <input type="text" class="datepicker">-->
    <?php foreach($gemaakteReserveringen as $i => $gemaakteReservering ) { ?>
        <?php
        //Use the 'modulus' check to define a odd/even class for the table rows
        $rowClass = 'odd';
        if ($i % 2 > 0) {
            $rowClass = 'even';
        }
        $id = $gemaakteReservering['id'];
        ?>
        <tr class="<?= $rowClass; ?>">
            <td><?= $i + 1; ?>
            <td><?= $gemaakteReservering['Voornaam']; ?></td>
            <td><?= $gemaakteReservering['Achternaam']; ?></td>
            <td><?= $gemaakteReservering['Straatnaam']; ?></td>
            <td><?= $gemaakteReservering['Email']; ?></td>
            <td><?= $gemaakteReservering['Telefoon']; ?></td>
            <td><?= $gemaakteReservering['Bezoekerspas']; ?></td>
            <td><a href="deleteFromTable.php?id=<?= $id; ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript" src="js/init.js"></script>
</body>
</html>