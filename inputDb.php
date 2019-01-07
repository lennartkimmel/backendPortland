<?php
// hiermee koppel je dit .php bestand aan de database
include_once 'includes/connectToDb.php';

// Hiermee koppel je F
if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $firstName = $_POST['Voornaam'];
    $lastName = $_POST['Achternaam'];
    $street = $_POST['Straatnaam'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['Telefoon'];
    $visitorsPass = $_POST['Bezoekerspas'];

    //Check if data is valid & generate error if not so
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
    try{
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
    catch (PDOException $e) {
        $sMsg = '<p>
            Line: '.$e->getLine().'<br />
            File: '.$e->getFile().'<br />
            Message: '.$e->getMessage().'
        </p>';

        trigger_error($sMsg);
    }
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
<h1>Maak uw reservatie hier!</h1>
<?php if (isset($errors)) { ?>
    <ul class="errors">
        <?php foreach ($errors as $error) { ?>
            <li><?= $error; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="data-field">
        <label for="Voornaam">Voornaam</label>
        <input id="Voornaam" type="text" name="Voornaam" value="<?= (isset($firstName) ? $firstName : ''); ?>"/>
        <span><?= (isset($errors['Voornaam']) ? $errors['Voornaam'] : '') ?></span>
    </div>
    <div class="data-field">
        <label for="Achternaam">Achternaam</label>
        <input id="Achternaam" type="text" name="Achternaam" value="<?= (isset($lastName) ? $lastName : ''); ?>"/>
    </div>
    <div class="data-field">
        <label for="Straatnaam">Straatnaam</label>
        <input id="Straatnaam" type="text" name="Straatnaam" value="<?= (isset($street) ? $street : ''); ?>"/>
    </div>
    <div class="data-field">
        <label for="Email">Email</label>
        <input id="Email" type="email" name="Email" value="<?= (isset($email) ? $email : ''); ?>"/>
    </div>
    <div class="data-field">
        <label for="Telefoon">Telefoonnummer</label>
        <input id="Telefoon" type="number" name="Telefoon" value="<?= (isset($phoneNumber) ? $phoneNumber : ''); ?>"/>
    </div>
    <div class="data-field">
        <label for="Bezoekerspas">Bezoekerspas</label>
        <input id="Bezoekerspas" type="text" name="Bezoekerspas" value="<?= (isset($visitorsPass) ? $visitorsPass : ''); ?>"/>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
<div>
    <a href="index.php">Ga terug naar home</a>
</div>
</body>
</html>