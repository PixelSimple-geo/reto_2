<?php
/*
require_once $_SERVER["DOCUMENT_ROOT"] . 'statics/dependencies/PHPMailer/PHPMailer.php';
require_once $_SERVER["DOCUMENT_ROOT"] . 'statics/dependencies/PHPMailer/Exception.php';
require_once $_SERVER["DOCUMENT_ROOT"] . 'statics/dependencies/PHPMailer/SMTP.php';
*/

require_once "../statics/dependencies/PHPMailer/PHPMailer.php";
require_once "../statics/dependencies/PHPMailer/Exception.php";
require_once "../statics/dependencies/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject) {
    $from = "jorge.egea@ikasle.egibide.org";
    $message = "Hello";

    $mail = new PHPMailer(true);

    try {
        // Enable SMTP
        $mail->isSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "pixelsimple.geo@gmail.com";
        $mail->Password   = "pixelSimple2023";

        // Set other email parameters
        $mail->setFrom($from, 'Jorge');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo "Error: Unable to send email. Error details: " . $mail->ErrorInfo;
    }
}

sendEmail("theonblack90102002@gmail.com", "Hello There");
