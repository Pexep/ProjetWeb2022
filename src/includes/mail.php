<?php
include("config.php");
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $mail_host;
$mail->SMTPAuth = true;
$mail->Username = $mail_user;
$mail->Password = $mail_passwd;
$mail->SMTPSecure = 'tls';
$mail->Port = $mail_port;
$mail->setFrom($mail_from, $mail_from_name);


?>