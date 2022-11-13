<?php

session_start();
if (!$_SESSION['id']) {
    header("location: loginPage.html");
    exit;
}

?>