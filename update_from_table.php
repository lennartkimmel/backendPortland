<?php
//Require database in this file & image helpers
require_once "includes/connect_to_db.php";

$errors = [];
$rowId = $_GET['id'];

//Require the form validation handling
function getErrorsForEmptyFields($firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass, $pickedDate) {
    $errors = [];
    if ($firstName == "") {
        $errors[] = 'Voornaam moet ingevuld worden';
    }
    if ($lastName == "") {
        $errors[] = 'Achternaam moet ingevuld worden';
    }
    if ($street == "") {
        $errors[] = 'Straatnaam moet ingevuld worden';
    }
    if ($email == "") {
        $errors[] = 'Email adres moet ingevuld worden';
    }
    if ($phoneNumber == "") {
        $errors[] = 'Telefoonnummer moet ingevuld worden';
    }
    if ($visitorsPass == "") {
        $errors[] = 'Bezoekerspas moet ingevuld worden';
    }
    if ($pickedDate == "") {
        $errors[] = 'Datum moet ingevuld worden';
    }
    return $errors;
}

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $firstName      = mysqli_real_escape_string($db, $_POST['Voornaam']);
    $lastName       = mysqli_real_escape_string($db, $_POST['Achternaam']);
    $street         = mysqli_real_escape_string($db, $_POST['Straatnaam']);
    $email          = mysqli_real_escape_string($db, $_POST['Email']);
    $phoneNumber    = mysqli_real_escape_string($db, $_POST['Telefoon']);
    $visitorsPass   = mysqli_real_escape_string($db, $_POST['Bezoekerspas']);
    $pickedDate     = mysqli_real_escape_string($db, $_POST['Datum']);
    
    $errors = getErrorsForEmptyFields($firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass, $pickedDate);

    $hasErrors = !empty($errors);
    
    //Save variables to array so the form won't break
    $infoLijst = [
        'Voornaam'      => $firstName,
        'Achternaam'    => $lastName,
        'Straatnaam'    => $street,
        'Email'         => $email,
        'Telefoon'      => $phoneNumber,
        'Bezoekerspas'  => $visitorsPass,
        'Datum'         => $pickedDate
    ];

    if (empty($errors)) {
        //Update the record in the database
        $query = "UPDATE reserveringen
                  SET Voornaam = '$firstName', Achternaam = '$lastName', Straatnaam = '$street', Email = '$email', Telefoon = '$phoneNumber', Bezoekerspas = '$visitorsPass', Datum = '$pickedDate'
                  WHERE id = '$rowId'";
        $result = mysqli_query($db, $query);
        if ($result) {
            //Set success message
            $success = true;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }
    }
}

//Close connection
mysqli_close($db);
?>

<!doctype html>
<html>
<head>
    <title>Table edit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<h1>Update hier uw reservering!</h1>
<?php if (isset($errors) && !empty($errors)) { ?>
    <ul class="errors">
        <?php for ($i = 0; $i < count($errors); $i++) { ?>
            <li><?= $errors[$i]; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="Voornaam">Voornaam</label>
        <input id="Voornaam" type="text" name="Voornaam" value=""/>
    </div>
    <div class="data-field">
        <label for="Achternaam">Achternaam</label>
        <input id="Achternaam" type="text" name="Achternaam" value=""/>
    </div>
    <div class="data-field">
        <label for="Straatnaam">Straatnaam</label>
        <input id="Straatnaam" type="text" name="Straatnaam" value=""/>
    </div>
    <div class="data-field">
        <label for="Email">E-mail</label>
        <input id="Email" type="text" name="Email" value=""/>
    </div>
    <div class="data-field">
        <label for="Telefoon">Telefoonnummer</label>
        <input id="Telefoon" type="number" name="Telefoon" value=""/>
    </div>
    <div class="data-field">
        <label for="Bezoekerspas">Bezoekerspas</label>
        <input type="Bezoekerspas" type="text" name="Bezoekerspas" value=""/>
    </div>
    <div class="data-field">
        <label for="Datum">Datum</label>
        <input type="Datum" type="text" name="Datum" value=""/>
    </div>
    <div class="data-submit">
        <input type="hidden" name="id" value="<?= $rowId; ?>"/>
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
<div>
    <a href="show_table.php">Go back to the list</a>
</div>
</body>
</html>

