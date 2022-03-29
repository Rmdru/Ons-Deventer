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
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}