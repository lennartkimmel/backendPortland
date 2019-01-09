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
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<!--<button>Create</button>-->
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Straatnaam</th>
        <th>Email</th>
        <th>Telefoon</th>
        <th>Bezoekerspas</th>
    </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>

    <?php foreach($gemaakteReserveringen as $i => $gemaakteReservering ) { ?>
        <?php
        //Use the 'modulus' check to define a odd/even class for the table rows
        $rowClass = 'odd';
        if ($i % 2 > 0) {
            $rowClass = 'even';
        }
        ?>
        <tr class="<?= $rowClass; ?>">
            <td><?= $i + 1; ?>
            <td><?= $gemaakteReservering['Voornaam']; ?></td>
            <td><?= $gemaakteReservering['Achternaam']; ?></td>
            <td><?= $gemaakteReservering['Straatnaam']; ?></td>
            <td><?= $gemaakteReservering['Email']; ?></td>
            <td><?= $gemaakteReservering['Telefoon']; ?></td>
            <td><?= $gemaakteReservering['Bezoekerspas']; ?></td>
            <!--            <td><a href="--><?//= $gemaakteReservering['Details']?><!--"</a>Details</td>-->
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>