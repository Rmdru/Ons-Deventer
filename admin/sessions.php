<?php
//start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//force https redirect
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

//check if the session time is valid
if (isset($_SESSION['userLoginTime'])) {
    if ((time() - 3600) > $_SESSION['userLoginTime']) {
        unset($_SESSION['userUuid']);
        unset($_SESSION['userIpAddress']);
        unset($_SESSION['userLoginTime']);
        unset($_SESSION['userLoggedIn']);
        unset($_SESSION['userRole']);
    
        setcookie("autologin", "", time() - (84600 * 366), "/", "", true, true);
    
        header("location: https://" . $_SERVER['SERVER_NAME'] . "/inloggen?loggedOut=2");
    }
} else {
    header("location: https://" . $_SERVER['SERVER_NAME'] . "/inloggen?loggedOut=2");
}

//check if user has not changed his ip address
if (isset($_SESSION['userIpAddress'])) {
    if ($_SESSION['userIpAddress'] != $_SERVER['REMOTE_ADDR']) {
        unset($_SESSION['userUuid']);
        unset($_SESSION['userIpAddress']);
        unset($_SESSION['userLoginTime']);
        unset($_SESSION['userLoggedIn']);
        unset($_SESSION['userRole']);

        setcookie("autologin", "", time() - (84600 * 366), "/", "", true, true);

        header("location: https://" . $_SERVER['SERVER_NAME'] . "/inloggen?loggedOut=1");
    }
} else {
    header("location: https://" . $_SERVER['SERVER_NAME'] . "/inloggen?loggedOut=1");
}

//check if user is logged in
if (!isset($_SESSION['userLoggedIn'])) {
    unset($_SESSION['userUuid']);
    unset($_SESSION['userIpAddress']);
    unset($_SESSION['userLoginTime']);
    unset($_SESSION['userLoggedIn']);
    unset($_SESSION['userRole']);

    setcookie("autologin", "", time() - (84600 * 366), "/", "", true, true);

    header("location: https://" . $_SERVER['SERVER_NAME'] . "/inloggen");
}