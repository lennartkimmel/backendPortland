<?php
// With this line of code you can connect this .php file to the database
include_once 'includes/connect_to_db.php';

$errors = [];

    if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $firstName      = mysqli_real_escape_string($db, $_POST['Voornaam']);
    $lastName       = mysqli_real_escape_string($db, $_POST['Achternaam']);
    $street         = mysqli_real_escape_string($db, $_POST['Straatnaam']);
    $email          = mysqli_real_escape_string($db, $_POST['Email']);
    $phoneNumber    = mysqli_real_escape_string($db, $_POST['Telefoon']);
    $visitorsPass   = mysqli_real_escape_string($db, $_POST['Bezoekerspas']);
    $pickedDate     = mysqli_real_escape_string($db, $_POST['Datum']);

// Checks if there are errors and shows errors for every empty field
    $errors = getErrorsForEmptyFields($firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass);

    $hasErrors = !empty($errors);

    if (!$hasErrors) {
        insertReservationIntoDatabase($db, $firstName, $lastName, $street, $email, $phoneNumber, $visitorsPass);
    }
    header("Location: email.php");
    die();
}

// Checks if $errors is not empty if it is > it will echo errors as HTML on the client side.
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

// Does the name of the function. It gives errors back when fields are left open
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

    $query = "INSERT INTO reserveringen (Voornaam, Achternaam, Straatnaam, Email, Telefoon, Bezoekerspas)
                  VALUES ('$firstName', '$lastName', '$street', '$email', '$phoneNumber', '$visitorsPass')";
    $result = mysqli_query($db, $query)
    or die('Error: '.$query);
    //When you inserted data into the table you'll get redirected to the email.php page
    if ($result) {
        header('Location: email.php');
        exit;
    } else {
        $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
    }
    //Close connection
    mysqli_close($db);
}
?>

<!doctype html>
<html>
<head>
    <title>Reservering</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
</head>
<body>
<section class="backgroundtheme black-text" id="welcome">
    <img src="images/PortlandLogo.png">
    <br><br>
    <h3 class="center-align center">Maak hier uw reservering</h3>
    <h4 class="center-align center">voor het wijkrestaurant</h4>
    <br><br>
</section>

<?php
showErrorsOnClientSide($errors);
?>

<!--in een FORM moeten altijd meerdere attributen zitten zoals: type (verplicht bij HTML)  -> name (Verplicht bij php anders niet opgenomen in PHP)-> value-->
<section class="sectionBody">
    <div class="container">
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
            <br>
            <div class="date-picker">
                <label for="date-start">Kies uw dag</label>
                <input type="date" name="Datum">
            </div>
            <br>
            <br>
            <div class="">
                <label for="Voornaam" class="labels">Voornaam</label>
                <input class="" type="text" name="Voornaam" placeholder="Voornaam" value="<?= (isset($firstName) ? $firstName : ''); ?>"/>
            </div>
            <div class="">
                <label for="Achternaam" class="labels">Achternaam</label>
                <input class="" type="text" name="Achternaam" placeholder="Achternaam" value="<?= (isset($lastName) ? $lastName : ''); ?>"/>
            </div>
            <div class="">
                <label for="Straatnaam" class="labels">Straatnaam</label>
                <input class="" type="text" name="Straatnaam" placeholder="Straatnaam" value="<?= (isset($street) ? $street : ''); ?>"/>
            </div>
            <div class="">
                <label for="Email">Email</label>
                <input class="" type="email" name="Email" placeholder="Email" value="<?= (isset($email) ? $email : ''); ?>"/>
            </div>
            <div class="">
                <label for="Telefoon">Telefoonnummer</label>
                <input class="" type="number" name="Telefoon" placeholder="Telefoonnummer" value="<?= (isset($phoneNumber) ? $phoneNumber : ''); ?>"/>
            </div>
            <div class="">
                <label for="Bezoekerspas">Bezoekerspas</label>
                <input class="" type="text" name="Bezoekerspas" placeholder="Bezoekerspas" value="<?= (isset($visitorsPass) ? $visitorsPass : ''); ?>"/>
            </div>
            <div class="data-submit">
                <input type="submit" name="submit" value="Reserveren"/>
            </div>

            <div id="endResult">
            </div>




            <div class="data-submit">
                <a class="" href="https://www.hulpcentrumportland.nl/"><u>Naar home</u></a>
            </div>
<!--            <div class="date-picker">-->
<!--                <label for="date-start">Kies uw dag</label>-->
<!--                <input type="date" name="Datum">-->
<!--            </div>-->
<!--            <div>-->
<!--                <label for="Datum">Datum</label>-->
<!--                <input type="text" class="datepicker" name="Datum">-->
<!--            </div>-->
        </form>
    </div>
</section>

<section>
    <div class="btn2">
        <a class="" href="https://autoriteitpersoonsgegevens.nl/sites/default/files/atoms/files/2017-11_stappenplan_avg_online_v2.pdf"><b>Info AVG</b></a>
    </div>
</section>
<footer class="footerIndex">
    <ul>
        <li>CONTACT</li>
        <li>Stichting Hulp- en Ontmoetingscentrum Portland</li>
        <li>Portlandstraat 57 | 3086 XG | Rotterdam</li>
        <li> 010 - 429 27 30</li>
        <li>info@hulpcentrumportland.nl</li>
        <li>KvK: 66134617 | Giften: NL68RABO0311225756 | ANBI instelling: 856409455</li>
    </ul>
</footer>
<!-- Javascripts -->
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script>

    // Main
    var APP = (function() {

        // Scope object
        var scope = {};

        // Initialisation method (constructor)
        var init = function() {
            bind();
        }

        // Event binding on HTML elements
        var bind = function() {
            let input = document.getElementById('searchMTG');
            input.onchange = ((evt) => { 
                let text = evt.target.value;

                scope.searchCards(text);
            });
        }

        // Search the cards with the help of the API (web call)
        scope.searchCards = function(input) {
            fetch(`https://api.scryfall.com/cards/search?q=${input}`).then(result => {
                result.json().then(json => {
                
                    renderCards(json.data);
                });
            });
        }

        // Draw the result cards to the screen
        var renderCards = function(cards) {

            // Get reference to the result window
            let container = document.getElementById('endResult');
            
            // Clear previous results
            container.innerHTML = null;

            for(card of cards) {
                let element = document.createElement('div');

                let title = document.createElement('h2');
                title.innerHTML = card.name;

                let image = document.createElement('img');
                image.src = card.image_uris.small;

                // Add title and image to 'element'
                element.append(title);
                element.append(image);

                // Add element to container
                container.append(element);
            }
        }

        // Initialisation
        init();

        // Return scope
        return scope;

    })();

</script>
</body>
</html>