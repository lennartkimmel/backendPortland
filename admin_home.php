<?php
session_start();

$cards = array();

if (isset($_GET['cardname'])) {

    $cardname = $_GET['cardname'];

    $json = file_get_contents('https://api.scryfall.com/cards/search?q=' . $cardname);
    $cards = json_decode($json)->data;
}

// Confirm login. Otherwise redirect to the login page
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: admin_login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>Document</title>
</head>
<body class="home-body">
<header>
    <img src="images/PortlandLogo.png" class="adminloginlogo">
</header>
<div class="admin-home-button">
    <?php if (isset($_SESSION['email'])) { ?>
    <div class="btn-container" align="center">
        <div>
            <input type="text" id="searchMTG" name="ZoekKaarten" placeholder="type name of card here..." />
        </div>

        <?php foreach ($cards as $card) { ?>
             <img src="<?= print($card->image_uris->normal) ?>"/>
         <?php } ?>

        <br>
        <br>
        <div class="btn1">
            <a class="" href="show_table.php"><b>Reserveringen</b></a>
        </div>
        <br>
        <br>
        <div class="btn1">
            <a class="" href="admin.php"><b>Create new user</b></a>
        </div>
        <br>
        <br>
        <div class="btn1">
            <a class="" href="admin_logout.php"><b>Logout</b></a>
        </div>
    </div>
</div>
<?php } ?>
<script type="text/javascript" src="js/api.js"></script>
</body>
</html>


