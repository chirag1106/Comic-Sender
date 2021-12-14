<?php
require __DIR__.'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->isHTML(true);
$mail->SMTPDebug = 0;									
$mail->isSMTP();											
$mail->Host	 = 'smtp.gmail.com;';					
$mail->SMTPAuth = true;							
$mail->Username = 'chirag.webdeveloper123@gmail.com'; // from email			
$mail->Password = 'chirag@123'; // email password						
$mail->SMTPSecure = 'tls';							
$mail->Port	 = 587;
$mail->setFrom('chirag.webdevloper123@gmail.com', 'Chirag Gupta');

$conn = new mysqli("localhost", "root", "", "comic_reader");
if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
}
?>