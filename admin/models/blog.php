<?php
//load config.php and functions.php
require "../../config/config.php";
require "../../functions/functions.php";

//data array
$data = [];

//get action
$action = validateData('action');

//get current date and time
$dateTime = date("Y-m-d H:i");

//run action
if ($action == "read") {
    //options
    $sortBy = validateData('sortBy');

    //query base
    $sql = "SELECT url, DATE_FORMAT(dateTime, '%d-%m-%Y %H:%i') AS dateTimeFormatted, readTime, title, author, visibility, views FROM `blog` WHERE 1=1";

    //query options
    if ($sortBy == "dateTimeAsc") {
        $sql .= " ORDER BY dateTime ASC";
    } else if ($sortBy == "viewsDesc") {
        $sql .= " ORDER BY views DESC";
    } else if ($sortBy == "viewsAsc") {
        $sql .= " ORDER BY views ASC";
    } else if ($sortBy == "readTimeDesc") {
        $sql .= " ORDER BY readTime DESC";
    } else if ($sortBy == "readTimeAsc") {
        $sql .= " ORDER BY readTime ASC";
    } else if ($sortBy == "titleAsc") {
        $sql .= " ORDER BY title ASC";
    } else if ($sortBy == "titleDesc") {
        $sql .= " ORDER BY title DESC";
    } else {
        $sql .= " ORDER BY dateTime DESC";
    }

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        //execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //fetch result and append to array
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                $_SESSION['userLoginTime'] = time();
            } else {
                $data = "noBlogsFound";
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
    $error = 0;
    $uuid = generateUuid();
    $csrfTokenSession = $_SESSION["csrfToken"];
    $csrfTokenInput = $_POST["csrfToken"];
    $imgFileType = "";
    $title = validateData("title");
    $bodyTxt = $_POST["bodyTxt"];
    $bodyTxtSanitized = $bodyTxt;
    $bodyTxtSanitized = strip_tags($bodyTxtSanitized);
    $bodyTxtSanitized = htmlspecialchars($bodyTxtSanitized);
    $bodyTxtSanitized = stripslashes($bodyTxtSanitized);
    $bodyTxtSanitized = trim($bodyTxtSanitized);
    $bodyTxtSanitized = htmlentities($bodyTxtSanitized);
    $url = validateData("url");
    $author = validateData("author");
    $readTime = validateData("readTime");
    $readTime = intval($readTime);
    $uploadMomentSelect = validateData("uploadMomentSelect");
    $uploadMoment = validateData("uploadMoment");
    $hiddenField = $_POST["hiddenField"];
    $views = 0;
    $visibility = 1;

    if ($csrfTokenSession != $csrfTokenInput) {
        $error++;
    }

    if (empty($title)) {
        $error++;
    }

    if (empty($bodyTxt)) {
        $error++;
    }

    if (empty($bodyTxtSanitized)) {
        $error++;
    }

    $urlPattern1 = "/[ ]/";
    $urlPattern2 = "/[^a-zA-Z0-9-]/";
    if (empty($url) OR preg_match($urlPattern1, $url) == 1 OR preg_match($urlPattern2, $url) == 1) {
        $error++;
    }

    if (empty($author)) {
        $error++;
    }

    $readTimePattern ="/[^0-9]/";
    if (empty($readTime) OR preg_match($readTimePattern, $readTime) == 1) {
        $error++;
    }

    if ($uploadMomentSelect == "scheduled" AND empty($uploadMoment)) {
        $error++;
    }

    if ($uploadMomentSelect == "now") {
        $uploadMoment = $dateTime;
    }

    if (!empty($hiddenField)) {
        $error++;
    }

    if ($error == 0) {
        //query
        $sql = "INSERT INTO `blog` (uuid, url, dateTime, author, title, bodyTxt, bodyTxtSanitized, imgFileType, views, visibility, readTime) VALUES (:uuid, :url, :dateTime, :author, :title, :bodyTxt, :bodyTxtSanitized, :imgFileType, :views, :visibility, :readTime)";

        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":uuid", $uuid);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":dateTime", $uploadMoment);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":bodyTxt", $bodyTxt);
            $stmt->bindParam(":bodyTxtSanitized", $bodyTxtSanitized);
            $stmt->bindParam(":imgFileType", $imgFileType);
            $stmt->bindParam(":views", $views);
            $stmt->bindParam(":visibility", $visibility);
            $stmt->bindParam(":readTime", $readTime);
            //execute query
            if ($stmt->execute()) {
                $_SESSION['blogUploadUuid'] = $uuid;
                $data = "success";

                $_SESSION['userLoginTime'] = time();
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
} else if ($action == "writeThumbnail") {
    $uuid = $_SESSION["blogUploadUuid"];
    $file = $_FILES['file'];
    $fileTempLocation = $file['tmp_name'];
    $fileName = $file['name'];
    $fileDestinationFolder = "../../img/blog/";
    $imgFileType = explode(".", $fileName);
    $imgFileType = $imgFileType[1];
    $fileName = $uuid . "." . $imgFileType;

    if ($fileName != "") {
        move_uploaded_file($fileTempLocation, $fileDestinationFolder.$fileName);
    }

    //query base
    $sql = "UPDATE `blog` SET imgFileType = :imgFileType WHERE uuid = :uuid";

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        $stmt->bindParam(":uuid", $uuid);
        $stmt->bindParam(":imgFileType", $imgFileType);
        //execute query
        if ($stmt->execute()) {
            $_SESSION['userLoginTime'] = time();

            header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog?blogUploadStatus=success");
        } else {
            header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog-toevoegen?blogUploadStatus=failed");
        }
    } else {
        header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog-toevoegen?blogUploadStatus=failed");
    }
} else if ($action == "readSingle") {
    $blog = validateData("blog");

    //query base
    $sql = "SELECT uuid, title, bodyTxt, author, visibility, imgFileType FROM `blog` WHERE 1=1 AND url = :blog";

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

                $_SESSION['userLoginTime'] = time();
            } else {
                $data = "redirect404";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }

    //encode data to json
    echo json_encode($data);
} else if ($action == "edit") {
    $error = 0;
    $uuid = $_POST["uuid"];
    $csrfTokenSession = $_SESSION["csrfToken"];
    $csrfTokenInput = $_POST["csrfToken"];
    $title = validateData("title");
    $bodyTxt = $_POST["bodyTxt"];
    $bodyTxtSanitized = $bodyTxt;
    $bodyTxtSanitized = strip_tags($bodyTxtSanitized);
    $bodyTxtSanitized = htmlspecialchars($bodyTxtSanitized);
    $bodyTxtSanitized = stripslashes($bodyTxtSanitized);
    $bodyTxtSanitized = trim($bodyTxtSanitized);
    $bodyTxtSanitized = htmlentities($bodyTxtSanitized);
    $url = validateData("url");
    $author = validateData("author");
    $readTime = validateData("readTime");
    $readTime = intval($readTime);
    $hiddenField = $_POST["hiddenField"];
    $visibility = validateData("visibility");
    $imgOldFileType = $_POST["imgFileType"];

    if ($csrfTokenSession != $csrfTokenInput) {
        $error++;
    }

    if (empty($title)) {
        $error++;
    }

    if (empty($bodyTxt)) {
        $error++;
    }

    if (empty($bodyTxtSanitized)) {
        $error++;
    }

    $urlPattern1 = "/[ ]/";
    $urlPattern2 = "/[^a-zA-Z0-9-]/";
    if (empty($url) OR preg_match($urlPattern1, $url) == 1 OR preg_match($urlPattern2, $url) == 1) {
        $error++;
    }

    if (empty($author)) {
        $error++;
    }

    $readTimePattern ="/[^0-9]/";
    if (empty($readTime) OR preg_match($readTimePattern, $readTime) == 1) {
        $error++;
    }

    if (!empty($hiddenField)) {
        $error++;
    }

    if ($error == 0) {
        //query
        $sql = "UPDATE `blog` SET url = :url, author = :author, title = :title, bodyTxt = :bodyTxt, bodyTxtSanitized = :bodyTxtSanitized, visibility = :visibility, readTime = :readTime WHERE uuid = :uuid";

        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":uuid", $uuid);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":bodyTxt", $bodyTxt);
            $stmt->bindParam(":bodyTxtSanitized", $bodyTxtSanitized);
            $stmt->bindParam(":visibility", $visibility);
            $stmt->bindParam(":readTime", $readTime);
            //execute query
            if ($stmt->execute()) {
                $_SESSION['blogEditUuid'] = $uuid;
                $_SESSION['blogEditOldFileType'] = $imgOldFileType;
                $data = "success";

                $_SESSION['userLoginTime'] = time();
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
} else if ($action == "editThumbnail") {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $imgFileType = explode(".", $fileName);
    $imgFileType = $imgFileType[1];
    if (!empty($imgFileType)) {
        $uuid = $_SESSION["blogEditUuid"];
        $oldFileType = $_SESSION["blogEditOldFileType"];
        unlink("https://" . $_SERVER["SERVER_NAME"] . "/img/blog/{$uuid}.{$oldFileType}");
        $fileTempLocation = $file['tmp_name'];
        $fileDestinationFolder = "../../img/blog/";
        $fileName = $uuid . "." . $imgFileType;
    
        if ($fileName != "") {
            move_uploaded_file($fileTempLocation, $fileDestinationFolder.$fileName);
        }
    
        //query base
        $sql = "UPDATE `blog` SET imgFileType = :imgFileType WHERE uuid = :uuid";
    
        //prepare query
        if ($stmt = $dbh->prepare($sql)) {
            $stmt->bindParam(":uuid", $uuid);
            $stmt->bindParam(":imgFileType", $imgFileType);
            //execute query
            if ($stmt->execute()) {
                $_SESSION['userLoginTime'] = time();

                header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog?blogEditStatus=success");
            } else {
                header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog-toevoegen?blogEditStatus=failed");
            }
        } else {
            header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog-toevoegen?blogEditStatus=failed");
        }
    } else {
        header("location: https://" . $_SERVER["SERVER_NAME"] . "/admin/blog?blogEditStatus=success");
    }
} else if ($action == "delete") {
    $url = validateData("url");

    //query base
    $sql = "DELETE FROM `blog` WHERE url = :url";

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        $stmt->bindParam(":url", $url);
        //execute query
        if ($stmt->execute()) {
            $_SESSION['userLoginTime'] = time();
            
            echo "success";
        } else {
            echo "failed";
        }
    } else {
        echo "failed";
    }
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}