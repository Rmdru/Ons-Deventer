<?php
//load config.php, sessions.php and functions.php
require "../../config/config.php";
require "../../functions/functions.php";
require "../sessions.php";

//data array
$data = [];

//get action
$action = validateData('action');

//vars
$uuid = $_SESSION['userUuid'];

//run action
if ($action == "readName") {
    //options
    $sortBy = validateData('sortBy');

    //query base
    $sql = "SELECT name FROM `user` WHERE 1=1 AND uuid = :uuid";

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        $stmt->bindParam(":uuid", $uuid);
        //execute query
        if ($stmt->execute()) {
            //fetch result and append to array
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }

    //encode data to json
    echo json_encode($data);
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
    
    //encode data to json
    echo json_encode($data);
}