<?php
//start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Access-Control-Allow-Origin: *');

//validate data
function validateData($value) {
    if (isset($_GET[$value])) {
        $value = strip_tags($_GET[$value]);
    } else if (isset($_POST[$value])) {
        $value = strip_tags($_POST[$value]);
    } else {
        return;
    }
    $value = htmlspecialchars($value);
    $value = stripslashes($value);
    $value = trim($value);
    $value = htmlentities($value);
    return $value;
}

//action
$action = validateData("action");

if ($action == "generateCaptcha") {
    generateCaptcha();
} else if ($action == "generatePsw") {
    generatePsw();
}

//generate uuid
function generateUuid() {
    $data = openssl_random_pseudo_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf("%s%s-%s-%s-%s%s%s", str_split(bin2hex($data), 4));
}

//generate captcha
function generateCaptcha() {
    $charsArray = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
    
    for ($i = 0; $i < 5; $i++) {
      $randomChar = array_rand($charsArray);
      if ($i != 0) {
        $captchaCode .= $charsArray[$randomChar];
      } else {
        $captchaCode = $charsArray[$randomChar];
      }
    }
    
    $_SESSION['captcha'] = $captchaCode;    
}

//generate captcha
function generatePsw() {
    $charsArray = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'), array("!","@","$","^","*","(",")","{","}","|","[","]",";",":","/"));
    
    for ($i = 0; $i < 16; $i++) {
      $randomChar = array_rand($charsArray);
      if ($i != 0) {
        $randomPsw .= $charsArray[$randomChar];
      } else {
        $randomPsw = $charsArray[$randomChar];
      }
    }
    
    echo $randomPsw; 
}