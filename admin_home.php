<?php
session_start();

$cards = array();

if (isset($_POST['submit'])) {
        $cardname = $_POST['ZoekKaarten'];
        $json = file_get_contents('https://api.scryfall.com/cards/search?q=' . $cardname);
        $cards = json_decode($json)->data;
    };

// Confirm login.
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    exit;
};
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
    <form action="" method="post">
        <div>
            <input type="text" id="searchMTG" name="ZoekKaarten" placeholder="type name of card here..." />
        </div>
        <div>
            <input type="submit" name="submit" value="Zoek je kaart!"/>
        </div>
    </form>
        <?php foreach (array_slice($cards, 0, 4) as $card ) { ?>
           <div>
            <img src="<?= $card->image_uris->normal?>"/>
            </div>
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
</body>
</html>


