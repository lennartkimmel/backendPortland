<?php
//Require database in this file & image helpers
require_once "includes/connect_to_db.php";

$errors = [];
$rowId = $_GET['id'];


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
    
    //Save variables to array so the form won't break
    $infoLijst = [
        'Voornaam' => $firstName,
        'Achternaam' => $lastName,
        'Straatnaam' => $street,
        'Email' => $email,
        'Telefoon' => $phoneNumber,
        'Bezoekerspas' => $visitorsPass,
        'Datum' => $pickedDate
    ];

    if (empty($errors)) {
        //Update the record in the database
        $query = "UPDATE albums
                  SET name = '$firstName', Achternaam = '$lastName', Straatnaam = '$street', Email = '$email', Telefoon = '$phoneNumber', Bezoekerspas = '$visitorsPass', Datum = '$pickedDate'
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
<h1>Edit "<?= $infoLijst['Voornaam'] . ' - ' . $infoLijst['Achternaam']; ?>"</h1>
<?php if (isset($errors) && !empty($errors)) { ?>
    <ul class="errors">
        <?php for ($i = 0; $i < count($errors); $i++) { ?>
            <li><?= $errors[$i]; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (isset($success)) { ?>
    <p class="success">Je album is bijgewerkt in de database</p>
<?php } ?>

<form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="voornaam">Voornaam</label>
        <input id="voornaam" type="text" name="voornaam" value="<?= $infoLijst['Voornaam']; ?>"/>
    </div>
    <div class="data-field">
        <label for="achternaam">Achternaam</label>
        <input id="achternaam" type="text" name="achternaam" value="<?= $infoLijst['Achternaam']; ?>"/>
    </div>
    <div class="data-field">
        <label for="straat">Straatnaam</label>
        <input id="straat" type="text" name="straat" value="<?= $infoLijst['Straatnaam']; ?>"/>
    </div>
    <div class="data-field">
        <label for="email">E-mail</label>
        <input id="email" type="text" name="email" value="<?= $infoLijst['Email']; ?>"/>
    </div>
    <div class="data-field">
        <label for="phonenumber">Telefoonnummer</label>
        <input id="phonenumber" type="number" name="phonenumber" value="<?= $infoLijst['Telefoon']; ?>"/>
    </div>
    <div class="data-field">
        <label for="bezoekerspas">Bezoekerspas</label>
        <input type="bezoekerspas" type="text" name="bezoekerspas" value="<?= $infoLijst['Bezoekerspas']; ?>"/>
    </div>
    <div class="data-field">
        <label for="datum">Datum</label>
        <input type="datum" type="text" name="datum" value="<?= $infoLijst['Datum']; ?>"/>
    </div>
    <div class="data-submit">
        <input type="hidden" name="id" value="<?= $rowId; ?>"/>
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
<div>
    <a href="index.php">Go back to the list</a>
</div>
</body>
</html>

