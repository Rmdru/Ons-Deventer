<?php
//load config.php and functions.php
require "../config/config.php";
require "../functions/functions.php";

//data array
$data = [];

//get action
$action = validateData('action');

//run action
if ($action == "send") {
    $error = 0;
    $csrfTokenInput = $_POST['csrfToken'];
    $csrfTokenSession = $_SESSION['csrfToken'];
    $name = validateData("name");
    $emailFrom = validateData("email");
    $subject = validateData("subject");
    $msg = validateData("msg");
    $hiddenField = $_POST["hiddenField"];
    $captchaInput = $_POST['captcha'];
    $captchaSession = $_SESSION['captcha'];
    $mailTo = "onsdeventer@rubenderuijter.nl";
    $headers = "From: {$name} <{$emailFrom}>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $content = "<!doctype html>
    <html>
        <body style='width: 600px;'>
            <p>Naam: {$name}</p>
            <p>E-mailadres: {$emailFrom}</p>
            <p>Onderwerp: {$subject}</p>
            <p>Bericht: {$msg}</p>
        </body>
    </html>";

    //validate data
    if ($csrfTokenInput != $csrfTokenSession) {
        $error++;
    }

    if ($captchaInput != $captchaSession) {
        $error++;
    }

    if (empty($name) OR empty($emailFrom) OR empty($subject) OR empty($msg)) {
        $error++;
    }

    if (!filter_var($emailFrom, FILTER_SANITIZE_EMAIL)) {
        $error++;
    }

    if (preg_match("/http/", $msg) != 0) {
        $error++;
    }

    if (!empty($invisibleField)) {
        $error++;
    }

    if ($error == 0) {
        mail($mailTo, $subject, $content, $headers);
        echo "success";
    } else {
        echo "failed";
    }

    generateCaptcha();
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}