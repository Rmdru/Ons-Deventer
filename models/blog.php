<?php
//load config.php and functions.php
require "../config/config.php";
require "../functions/functions.php";

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
    $sql = "SELECT uuid, url, DATE_FORMAT(dateTime, '%d-%m-%Y %H:%i') AS dateTimeFormatted, readTime, title, bodyTxtSanitized, imgFileType FROM `blog` WHERE 1=1 AND visibility = 1 AND dateTime <= :dateTime";

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
        $stmt->bindParam(":dateTime", $dateTime);
        //execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //fetch result and append to array
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
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
} else if ($action == "readSingle") {
    //options
    $blog = validateData('blog');

    //query base
    $sql = "SELECT uuid, url, DATE_FORMAT(dateTime, '%d-%m-%Y %H:%i') AS dateTimeFormatted, author, title, bodyTxt, imgFileType, readTime, views FROM `blog` WHERE 1=1 AND visibility = 1 AND dateTime <= :dateTime AND url = :blog";

    //prepare query
    if ($stmt = $dbh->prepare($sql)) {
        $stmt->bindParam(":dateTime", $dateTime);
        $stmt->bindParam(":blog", $blog);
        //execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //fetch result and append to array
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $views = $row['views'];
                    $data[] = $row;
                }

                $views = $views + 1;
                $sql = "UPDATE `blog` SET views = :views WHERE url = :blog";
                if ($stmt = $dbh->prepare($sql)) {
                    $stmt->bindParam(":views", $views);
                    $stmt->bindParam(":blog", $blog);
                    $stmt->execute();
                }
            } else {
                $data = "blogNotFound";
            }
        } else {
            $data = "failed";
        }
    } else {
        $data = "failed";
    }

    //encode data to json
    echo json_encode($data);
} else if ($action == "readRecent") {
    //options
    $sortBy = validateData('sortBy');
    $url = validateData('url');

    //query base
    $sql = "SELECT uuid, url, DATE_FORMAT(dateTime, '%d-%m-%Y %H:%i') AS dateTimeFormatted, readTime, title, bodyTxtSanitized, imgFileType FROM `blog` WHERE 1=1 AND visibility = 1 AND dateTime <= :dateTime AND url <> :url";

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
        $stmt->bindParam(":dateTime", $dateTime);
        $stmt->bindParam(":url", $url);
        //execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //fetch result and append to array
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
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
} else {
    $data = "failed";
    
    //encode data to json
    echo json_encode($data);
}