<?php

require_once "../statics/dependencies/PHPMailer/src/PHPMailer.php";
require_once "../statics/dependencies/PHPMailer/src/Exception.php";
require_once "../statics/dependencies/PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($subject, $message, $to = "theonblack90102002@gmail.com") {
    $mail = new PHPMailer(true);

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "theonblack90102002@gmail.com";
        $mail->Password = "nxxhplllttqwkscw";
        $mail->SMTPSecure = "ssl";
        $mail->Port = "465";

        $mail->setFrom("theonblack90102002@gmail.com");
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    } catch (Exception $e) {
        echo "Error: Unable to send email. Error details: " . $mail->ErrorInfo;
    }
}
