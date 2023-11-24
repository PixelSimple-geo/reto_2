<?php

function sendEmail($to, $subject) {
    $from = "jorge.egea@ikasle.egibide.org";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-Type: text/html\r\n";
    $message = "Hello";

    $mail_success = mail($to, $subject, $message, $headers);

    if ($mail_success) {
        echo "Email sent successfully.";
    } else {
        echo "Error: Unable to send email.";
    }
}

sendEmail("theonblack90102002@gmail.com", "hello there");