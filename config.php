<?php
require __DIR__.'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->isHTML(true);
$mail->SMTPDebug = -1;									
$mail->isSMTP();											
$mail->Host	 = 'smtp.gmail.com';					
$mail->SMTPAuth = true;							
$mail->Username = ''; // from email			
$mail->Password = ''; // email password						
$mail->SMTPSecure = 'ssl';							
$mail->Port	 = 465; 
$mail->setFrom('', ''); // your email, name

$conn = new mysqli("","", "", "");
if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
}
?>
