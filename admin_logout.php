<?php
session_start();
session_destroy();

//Redirect
header("Location: admin_login.php");
exit;