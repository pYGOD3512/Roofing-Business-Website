<?php

// Define Host Info || Who is sending emails?
define("HOST_NAME", "Poitech Mailer");
define("HOST_EMAIL", "poitech@mail.com");

// Define SMTP Credentials || Gmail Informations
define("SMTP_EMAIL", "mail@gmail.com");
define("SMTP_PASSWORD", "your_gmail_pass"); // read documentations


// Define Recipent Info ||  Who will get this email?
define("RECIPIENT_NAME", "John Doe");
define("RECIPIENT_EMAIL", "jhon@mail.com");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';





//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	//Server settings
	$mail->SMTPDebug = 0;                      //Enable verbose debug output
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = SMTP_EMAIL;                     //SMTP username
	$mail->Password   = SMTP_PASSWORD;                               //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
	$mail->setFrom(HOST_EMAIL, HOST_NAME);
	$mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME);     //Add a recipient

	//Content
	$name = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
	$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
	$phone = isset($_POST['phone']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
	$services = isset($_POST['services']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['services']) : "";
	$subject = isset($_POST['subject']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
	$address = isset($_POST['address']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['address']) : "";
	$website = isset($_POST['website']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['website']) : "";
	$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

	$mail->isHTML(true);                                  //Set email format to HTML
	$mail->Subject = 'A contact request send by ' . $name;
	$mail->Body    = 'Name: ' . $name . "<br>";
	$mail->Body .= 'Email: ' . $senderEmail . "<br>";


	if ($phone) {
		$mail->Body .= 'Phone: ' . $phone . "<br>";
	}
	if ($services) {
		$mail->Body .= 'services: ' . $services . "<br>";
	}
	if ($subject) {
		$mail->Body .= 'Subject: ' . $subject . "<br>";
	}
	if ($address) {
		$mail->Body .= 'Address: ' . $address . "<br>";
	}
	if ($website) {
		$mail->Body .= 'Website: ' . $website . "<br>";
	}

	$mail->Body .= 'message: ' . "<br>" . $message;

	$mail->send();
	echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div><!-- /.inner -->";
} catch (Exception $e) {
	echo "<div class='inner error'><p class='error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p></div><!-- /.inner -->";
}
