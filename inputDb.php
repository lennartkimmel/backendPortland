<?php
// hiermee koppel je dit .php bestand aan de database
include_once 'includes/connectToDb.php';

$errors = [];

if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $firstName = $_POST['Voornaam'];
    $lastName = $_POST['Achternaam'];
    $street = $_POST['Straatnaam'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['Telefoon'];
    $visitorsPass = $_POST['Bezoekerspas'];


    $errors = getErrorsForEmptyFields($firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass);

    $hasErrors = !empty($errors);

    if (!$hasErrors) {
        insertReservationIntoDatabase($db, $firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass);
    }
}

function showErrorsOnClientSide ($errors) {
    $hasErrors = !empty($errors);
    if ($hasErrors) {
        echoErrorsAsHtml($errors);
    }
}

function echoErrorsAsHtml ($errors) {
    echo "<ul class='errors'>";

    foreach  ($errors as $error) {
        echo "<li>{$error}</li>";
    }
    echo "</ul>";
}

function getErrorsForEmptyFields($firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass) {
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
    return $errors;
}

function insertReservationIntoDatabase($db, $firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass) {

    $query = $db->prepare("
        
        INSERT INTO `reserveringen` (`Voornaam`, `Achternaam`, `Straatnaam`, `Email`, `Telefoon`, `Bezoekerspas`) VALUES (:Voornaam, :Achternaam, :Straatnaam, :Email, :Telefoon, :Bezoekerspas)");
    $query->bindParam(':Voornaam', $firstName);
    $query->bindParam(':Achternaam', $lastName);
    $query->bindParam(':Straatnaam', $street);
    $query->bindParam(':Email', $email);
    $query->bindParam(':Telefoon', $phoneNumber);
    $query->bindParam(':Bezoekerspas', $visitorsPass);
    $query->execute();
}

?>

<!doctype html>
<html>
<head>
    <title>Reservering</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<section class="sectionHeader">
    <h1 class="reservationHeader">Maak uw reservatie hier!</h1>
</section>

<?php
showErrorsOnClientSide($errors);
?>

<!--in een FORM moeten altijd meerdere attributen zitten zoals: type (verplicht bij HTML)  -> name (Verplicht bij php anders niet opgenomen in PHP)-> value-->
<section class="sectionBody">
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
        <div class="data-field">
            <label for="Voornaam" class="labels">Voornaam</label>
            <input class="inputField" type="text" name="Voornaam" placeholder="Voornaam" value="<?= (isset($firstName) ? $firstName : ''); ?>"/>
        </div>
        <div class="data-field">
            <label for="Achternaam" class="labels">Achternaam</label>
            <input class="inputField" type="text" name="Achternaam" placeholder="Achternaam" value="<?= (isset($lastName) ? $lastName : ''); ?>"/>
        </div>
        <div class="data-field">
            <label for="Straatnaam" class="labels">Straatnaam</label>
            <input class="inputField" type="text" name="Straatnaam" placeholder="Straatnaam" value="<?= (isset($street) ? $street : ''); ?>"/>
        </div>
        <div class="data-field">
            <label for="Email">Email</label>
            <input class="inputField" type="email" name="Email" placeholder="Email" value="<?= (isset($email) ? $email : ''); ?>"/>
        </div>
        <div class="data-field">
            <label for="Telefoon">Telefoonnummer</label>
            <input class="inputField" type="number" name="Telefoon" placeholder="Telefoonnummer" value="<?= (isset($phoneNumber) ? $phoneNumber : ''); ?>"/>
        </div>
        <div class="data-field">
            <label for="Bezoekerspas">Bezoekerspas</label>
            <input class="inputField" type="text" name="Bezoekerspas" placeholder="Bezoekerspas" value="<?= (isset($visitorsPass) ? $visitorsPass : ''); ?>"/>
        </div>
        <div class="data-submit">
            <input type="submit" name="submit" value="Save"/>
        </div>
    </form>
</section>
<!--<div>-->
<!--    <a href="index.php">Ga terug naar home</a>-->
<!--</div>-->
</body>
</html>