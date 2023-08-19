<?php

require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug=2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='donatingnest@gmail.com'; // SMTP username
    $mail->Password='wfpvfvwxvutzdxsg'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('support@bookland.com', 'bookland');

    //recipient
    $mail->addAddress('swathimathi5@gmail.com','SWATHI');     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Order Confrm';
    $mail->Body='Hi, Your ordr has been sucessfully Placed';
    $mail->AltBody='This is the body in plain text for non-HTML mail clients';

    $mail->send();

    header('location: index.php');
} 
catch(Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;
}

?>