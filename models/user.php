<?php
//load config.php and functions.php
require "../config/config.php";
require "../functions/functions.php";

//get action
$action = validateData('action');

//run action
if ($action == "logIn") {
    //vars
    $error = 0;
    $email = validateData("email");
    $pswUnencrypted = $_POST["psw"];
    $psw = sha1($pswUnencrypted);
    $autologin = validateData("autologin");
    $hiddenField = validateData("hiddenField");
    $csrfTokenInput = $_POST["csrfToken"];
    $csrfTokenSession = $_SESSION["csrfToken"];

    //check if hidden field is empty
    if (!empty($hiddenField)) {
        $error++;
    }

    //check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error++;
    }

    //check if psw is not empty
    if (empty($pswUnencrypted)) {
        $error++;
    }

    if ($csrfTokenInput != $csrfTokenSession) {
        $error++;
    }

    if ($error == 0) {
        //query to check if email exists
        $sql = "SELECT email, blocked FROM `user` WHERE 1=1 AND email = :email";

        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":email", $email);
            //execute query
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $blocked = $row['blocked'];
                    if ($blocked == 0) {
                        //query to verify if psw is correct
                        $sql = "SELECT uuid, email, role FROM `user` WHERE 1=1 AND email = :email AND psw = :psw";
                    
                        //prepare query
                        if ($stmt = $dbh->prepare($sql)) {
                            $stmt->bindParam(":email", $email);
                            $stmt->bindParam(":psw", $psw);
                            //execute query
                            if ($stmt->execute()) {
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        //login user and set sessions
                                        $uuid = $row["uuid"];
                                        $role = $row["role"];
                                        $email = $row["email"];
                                        $_SESSION['userLoggedIn'] = 1;
                                        $_SESSION['userLoginTime'] = time();
                                        $_SESSION['userRole'] = $role;
                                        $_SESSION['userEmail'] = $email;
                                        $_SESSION['userUuid'] = $uuid;
                                        $_SESSION['userIpAddress'] = $_SERVER["REMOTE_ADDR"];

                                        //set autologin cookie if user checked autologin checkbox
                                        if ($autologin == 1) {
                                            setcookie("autologin", 1, time() + (86400 * 366), "/", "", true, true);
                                        }

                                        //regenerate session id
                                        session_regenerate_id();

                                        $data = "loggedInAsAdmin";                                  
                                    }
                                } else {
                                    //if psw is wrong, increment login attempt counter, if user login attempt is 3 or higher block account
                                    if (isset($_SESSION['userLoginAttempts'])) {
                                        $userLoginAttempts = $_SESSION['userLoginAttempts'];
                                        $userLoginAttempts++;
                                        $_SESSION['userLoginAttempts'] = $userLoginAttempts;

                                        if ($userLoginAttempts >= 5) {
                                            //update db to block user after 5 failed login attempts
                                            $sql = "UPDATE `user` SET blocked = 1 WHERE email = :email";
                
                                            //prepare query
                                            if ($stmt = $dbh->prepare($sql)) {
                                                $stmt->bindParam(":email", $email);
                                                //execute query
                                                $stmt->execute();
                                            }

                                            $data = "tooMuchLoginAttempts";
                                        } else {
                                            $data = "pswIncorrect";
                                        }
                                    } else {
                                        $_SESSION['userLoginAttempts'] = 1;

                                        $data = "pswIncorrect";
                                    }
                                }
                            } else {
                                $data = "failed";
                            }
                        } else {
                            $data = "failed";
                        }
                    } else {
                        $data = "accountBlocked";
                    }                    
                } else {
                    $data = "emailNotFound";
                }
            } else {
                $data = "failed";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }

    echo $data;
} else if ($action == "requestPswResetLink") {
    $error = 0;
    $email = validateData("email");
    $csrfTokenInput = $_POST["csrfToken"];
    $csrfTokenSession = $_SESSION["csrfToken"];
    $hiddenField = $_POST["hiddenField"];

    //check if hidden field is empty
    if (!empty($hiddenField)) {
        $error++;
    }

    //check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error++;
    }

    //check if csrf token is correct
    if ($csrfTokenInput != $csrfTokenSession) {
        $error++;
    }

    if ($error == 0) {
        $sql = "SELECT email FROM `user` WHERE 1=1 AND email = :email";

        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":email", $email);
            //execute query
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $charsArray = [];
                    $charsArray = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'), array("!","@","$","^","*","(",")","{","}","|","[","]",";",":","/"));

                    for ($i = 0; $i < 256; $i++) {
                        $randomChar = array_rand($charsArray);
                        if ($i != 0) {
                            $verificationToken .= $charsArray[$randomChar];
                        } else {
                            $verificationToken = $charsArray[$randomChar];
                        }
                    }

                    //curl handle
                    function curlHandle($url) {        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        
                        $jsonData = curl_exec($ch);

                        curl_close($ch);
                        
                        $data = json_decode($jsonData);

                        return $data;
                    }

                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    $ipAddressApi = curlHandle("https://ip-api.io/api/json/{$ipAddress}");
                    $country = $ipAddressApi->country_name;
                    if (empty($country)) {
                        $country = "Onbekend";
                    }
                    $city = $ipAddressApi->city;
                    if (empty($city)) {
                        $city = "Onbekend";
                    }
                    $dateTime = date("d-m-Y H:i");

                    $_SESSION['verificationToken'] = $verificationToken;
                    $_SESSION['pswResetEmail'] = $email;

                    $subject = "Nieuw wachtwoord aangevraagd - Ons Deventer";
                    $content = "<!doctype html>
                    <html>
                        <body style='width: 600px;'>
                            <h1>Er is een nieuw wachtwoord aangevraagd.</h1>
                            <h3>Het gaat om het account dat geregistreerd met het volgende e-mailadres: {$email}.</h3>
                            <p>De gegevens van de aanvrager:<br />Land: {$country}<br />Plaats: {$city}<br />Datum en tijd: {$dateTime}<br />IP-adres: {$ipAddress}<br /></p>
                            <a href='https://" . $_SERVER['HTTP_HOST'] . "/nieuw-wachtwoord?verificationToken={$verificationToken}'>Via deze link kan je een nieuw wachtwoord maken</a>
                            <p>De e-mail is automatisch verzonden, reacties op deze e-mail zullen niet beantwoord worden.</p>
                            <img src='https://" . $_SERVER['HTTP_HOST'] . "/img/logoTransparentSm.svg' width='300' />
                        </body>
                    </html>";
                    $headers = "From: Ons Deventer <noReply@onsdeventer.nl>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
                    mail($email, $subject, $content, $headers);

                    $data = "success";
                } else {
                    $data = "noAccount";
                }
            } else {
                $data = "failed";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }
    
    echo $data;
} else if ($action == "resetPsw") {
    $error = 0;
    $psw = $_POST["psw"];
    $pswResetEmail = $_SESSION["pswResetEmail"];
    $csrfTokenInput = $_POST["csrfToken"];
    $csrfTokenSession = $_SESSION["csrfToken"];
    $hiddenField = $_POST["hiddenField"];

    //check if hidden field is empty
    if (!empty($hiddenField)) {
        $error++;
    }

    //check if password field is empty
    if (empty($psw)) {
        $error++;
    }

    //encrypt password
    $psw = sha1($psw);

    //check if csrf token is correct
    if ($csrfTokenInput != $csrfTokenSession) {
        $error++;
    }

    if ($error == 0) {
        $sql = "UPDATE `user` SET psw = :psw WHERE 1=1 AND email = :email";

        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":email", $pswResetEmail);
            $stmt->bindParam(":psw", $psw);
            //execute query
            if ($stmt->execute()) {
                $data = "success";
            } else {
                $data = "failed";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }
    
    echo $data;   
} else {
    $data = "failed";

    echo $data;
}