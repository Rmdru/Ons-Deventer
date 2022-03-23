<?php
//start session
session_start();

unset($_SESSION['userUuid']);
unset($_SESSION['userIpAddress']);
unset($_SESSION['userLoginTime']);
unset($_SESSION['userLoggedIn']);
unset($_SESSION['userRole']);

setcookie("autologin", "", time() - (84600 * 366), "/", "", true, true);

header("location: ../inloggen");