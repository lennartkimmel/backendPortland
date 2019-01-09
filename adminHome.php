<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: adminLogin.php");
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
    <title>Document</title>
</head>
<body>
<?php if (isset($_SESSION['email'])) { ?>
<div class="naviButton">
    <ul>
        <li><a href="showTable.php">Reserveringen</a></li>
        <li><a href="logout.php">Logout</a></li>
</ul>
</div>
<?php } ?>
</body>
</html>


