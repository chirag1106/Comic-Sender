<?php
require __DIR__.'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->isHTML(true);
$mail->SMTPDebug = -1;									
$mail->isSMTP();											
$mail->Host	 = 'mail.comicsender.me';					
$mail->SMTPAuth = true;							
$mail->Username = 'admin@comicsender.me'; // from email			
$mail->Password = 'comic@admin123'; // email password						
$mail->SMTPSecure = 'ssl';							
$mail->Port	 = 465; 
$mail->setFrom('admin@comicsender.me', 'Comic Sender');

$conn = new mysqli("comicsender.me","comicsen_admin", "comic@admin123", "comicsen_comic_sender");
if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
}
?>