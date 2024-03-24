<?php
include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

$mailto = $_POST['email'];
$OTP = $_POST['OTP'];

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'manetestacc123@gmail.com';
$mail->Password = 'bbom uoyd jene oirm';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('manetestacc123@gmail.com', 'Mane Click');
$mail->addAddress($mailto);

$mail->addReplyTo('noreply@gmail.com', 'No Reply');

$mail->Subject = 'Mane Click One-Time Password';
$mail->IsHTML(true);

$content = 'Your code is: ' . $OTP . '. Use it to reset your password.<br><br>If you didn\'t request this, please contact the administrator.<br><br>Yours,<br>Mane Click Team';

$mail->Body = $content;

$response = [];

if ($mail->send()) {
    $response['success'] = true;
    $response['message'] = 'Email sent successfully';
} else {
    $response['success'] = false;
    $response['message'] = 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}

// Remove any HTML output before echoing JSON
ob_clean();

header('Content-Type: application/json');
echo json_encode($response);
?>