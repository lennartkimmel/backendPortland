<?php
session_start();
session_destroy();

//Redirect
header("Location: adminLogin.php");
exit;