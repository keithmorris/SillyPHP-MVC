<?php

include 'lib/class.phpmailer.php';

$mail             = new PHPMailer(); // defaults to using php "mail()"
$body             = file_get_contents('contents.html');
// $body             = preg_replace('/[\]/i','',$body);

$mail->SetFrom('kmorris@brownbagmarketing.com', 'Keith Morris');

// $mail->AddReplyTo("name@yourdomain.com","First Last");

$address = "standupbass@gmail.com";
$mail->AddAddress($address, "Keith Morris");

$mail->Subject    = "PHPMailer Test Subject via mail(), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

// $mail->AddAttachment("images/phpmailer.gif");      // attachment
// $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}