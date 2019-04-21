<?php
session_start();
//Require database in this file
require_once "includes/connect_to_db.php";

//If form is posted, lets validate!
if (isset($_POST['submit'])) {

    $email      = mysqli_escape_string($db, $_POST['email']);
    $password   = $_POST['password'];
    $errors     = [];

    if(empty($email)) {
        $errors['email'] = 'Email cannot be empty';
    }
    if(empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }
    // If everything is filled in the db can be checked
    if(empty($errors))
    {
        //Get the email from the DB
        $query  = sprintf("SELECT * FROM gebruikers WHERE email = '%s'", mysqli_escape_string($db, $email));
        $result = mysqli_query($db, $query);
        $user   = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //Check if email exists in database
        $errors = [];
        if ($user)
        {
            //Validate password
            if (password_verify($password, $user['password'])) {
                //Set email for later use in Session
                $_SESSION['email'] = $email;
                //Redirect to secure.php & exit script
                header("Location: admin_home.php");
                exit;
            } else {
                $errors['password'] = 'The password is incorrect';
            }
        } else {
            $errors['email'] = 'This email does not appear to exist.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Portland Login</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body class="adminloginbody">
<section class="adminloginhead">
    <img src="images/PortlandLogo.png" class="adminloginlogo">
</section>
<h1 class="loginheader">Portland login</h1>

<form id="login" method="post" action="<?= $_SERVER['REQUEST_URI']; ?>">
    <div>
        <label for="email">E-mail*</label>
        <input type="email" name="email" id="email" value="<?= (isset($email) ? $email : ''); ?>"/>
        <span class="error"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
    </div>
    <div>
        <label for="password">Wachtwoord*</label>
        <input type="password" name="password" id="password"/>
        <span class="error"><?= isset($errors['password']) ? $errors['password'] : ''; ?></span>
    </div>
    <div class="adminloginbutton">
        <input type="submit" name="submit" value="Login"/>
    </div>
    <img src="images/PortlandHuismerk.png" class="huismerkLogo">
</form>
</body>
</html>