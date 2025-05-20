<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$env = parse_ini_file(dirname(__DIR__, 2) . '/.env');


$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = $env['EMAIL_HOST'];
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = $env['EMAIL_PORT'];
$mail->Username = $env['EMAIL_NAME'];
$mail->Password = $env['EMAIL_PASSWORD'];

$mail->isHtml(true);

return $mail;

?>