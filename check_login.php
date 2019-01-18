<?php
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "Je moet eerst inloggen";
    header ('location: admin_login.php');
}