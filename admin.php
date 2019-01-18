<?php
//Require database in this file
require_once "includes/connect_to_db.php";

//If form is posted, lets validate!
if (isset($_POST['submit']))
{
    $email      = mysqli_escape_string($db, $_POST['email']);
    $password   = $_POST['password'];
    $errors = [];
    if(empty($email)) {
        $errors['email'] = 'Email cannot be empty';
    }
    if(empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }
    if(empty($errors)) {
        //hashes the password and inserts the hashed password and email into the database
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO gebruikers (email, password)
                  VALUES ('$email', '$password')";
        $result = mysqli_query($db, $query)
        or die('Error: '.mysqli_error($db));
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Register new user</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body class="adminloginbody">
<section class="adminloginhead">
    <img src="images/PortlandLogo.png" class="adminloginlogo">
</section>
<h1>New User</h1>
<form action="" method="post">
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
    <br>
    <div>
        <input type="submit" name="submit" value="Register"/>
    </div>
</form>
</body>
</html>