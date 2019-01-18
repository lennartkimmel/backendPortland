<?php
session_start();
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


