<?php
//load config.php and functions.php
require "../config/config.php";
require "../functions/functions.php";

//data array
$data = [];

//get action
$action = validateData('action');

//run action
if ($action == "read") {
    //options
    $blog = validateData('blog');

    //query base
    $sql = "SELECT uuid, DATE_FORMAT(dateTime, '%d-%m-%Y %H:%i') AS dateTimeFormatted, name, comment, anonymous FROM `comment` WHERE 1=1 AND blogId = :blog ORDER BY dateTime DESC";

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        $stmt->bindParam(":blog", $blog);
        //execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //fetch result and append to array
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            } else {
                $data = "noCommentsFound";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }

    //encode data to json
    echo json_encode($data);
} else if ($action == "write") {
    //options
    $error = 0;
    $blog = validateData('blog');
    $hiddenField = $_POST["hiddenField"];
    $csrfTokenInput = $_POST["csrfToken"];
    $csrfTokenSession = $_SESSION["csrfToken"];
    $anonymous = validateData('anonymous');
    $name = validateData('name');
    $comment = validateData('comment');
    $dateTime = date("Y-m-d H:i:s");
    $uuid = generateUuid();

    if (!empty($hiddenField)) {
        $error++;
    }

    if ($csrfTokenInput != $csrfTokenSession) {
        $error++;
    }

    if ($anonymous == 0 AND empty($name)) {
        $error++;
    }

    if (empty($comment)) {
        $error++;
    }

    if ($error == 0) {
        //query base
        $sql = "INSERT INTO `comment` (uuid, blogId, dateTime, name, comment, anonymous) VALUES (:uuid, :blog, :dateTime, :name, :comment, :anonymous)";
    
        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":uuid", $uuid);
            $stmt->bindParam(":blog", $blog);
            $stmt->bindParam(":dateTime", $dateTime);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":comment", $comment);
            $stmt->bindParam(":anonymous", $anonymous);
            //execute query
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "failed";
            }
        } else {
            echo "failed";
        }
    } else {
        // echo "failed";
        echo "{$csrfTokenSession}<br/><br/>{$csrfTokenInput}";
    }
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}