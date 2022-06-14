<?php
//load config.php, sessions.php and functions.php
require "../../config/config.php";
require "../../functions/functions.php";
require "../sessions.php";

//data array
$data = [];

//get action
$action = validateData('action');

//get current date and time
$dateTime = date("Y-m-d H:i");

if ($action == "edit") {
    //get csrf token
    $error = 0;
    
    if ($error == 0) {
        //convert php array to json
        $output = json_encode($_POST["data"]);
        
        //empty json file and overwrite it with form data
        file_put_contents("../../api/whoWeAre.json", "");
        file_put_contents("../../api/whoWeAre.json", $output);
    
        echo "success";
    } else {
        $data = "failed";
        
        //encode data to json
        echo json_encode($data);
    }
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}
?>