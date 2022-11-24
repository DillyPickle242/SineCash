<?php

$curPageName = basename($_SERVER["SCRIPT_NAME"]);

session_start();
if (!$_SESSION['id'] && !in_array($curPageName, array('loginPage.php', 'signupPage.php'))) {
    header("location: loginPage.php");
    exit;
}

//time set:
date_default_timezone_set('America/New_York');

?>