<?php
require_once "includes/connect_to_db.php";

$query =   "SELECT Email FROM reserveringen ORDER BY id DESC LIMIT 1";

$result = mysqli_query($db, $query)
or die('Error' .mysqli_error($db).'<br>query:'. $query);

$email = mysqli_fetch_assoc($result);



// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                // Enable verbose debug output
    $mail->isSMTP();                                     // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';                // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                            // Enable SMTP authentication
    $mail->Username   = 'lennartkimmel@gmail.com';       // SMTP username
    $mail->Password   = '!@#Krater666';                  // SMTP password
    $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                             // TCP port to connect to

    //Recipients
    $mail->setFrom('lennartkimmel@gmail.com', 'Lennart');
    // $mail->addAddress('lennartkimmel@gmail.com');
    $mail->addAddress($email['Email']);

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reservering Portland';
    $mail->Body    = "Uw afspraak is doorgegeven aan Wijkrestaurant Portland";

    $mail->Altbody = 'Dit is een test';

    $mail->send();
    echo 'Message has been sent';

    header("Location: index.php");
    die();
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>