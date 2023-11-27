<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./PHPMailer/src/Exception.php";
require_once "./PHPMailer/src/PHPMailer.php";
require_once "./PHPMailer/src/SMTP.php";


function sendEmail() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "theonblack90102002@gmail.com";
    $mail->Password = "nxxhplllttqwkscw";
    $mail->SMTPSecure = "ssl";
    $mail->Port = "465";

    $mail->setFrom("theonblack90102002@gmail.com");
    $mail->addAddress("pixelsimple.geo@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = "test";
    $mail->Body = "click aquí para verificar tu cuenta";
    $mail->send();
}

sendEmail();