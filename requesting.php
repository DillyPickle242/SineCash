<?php
include_once 'sessionStart.php';
include_once 'db_people.php';

$sender = $_POST['requestPersonSelect'];
$recipient = $_SESSION['id'];
$amount = $_POST['requestCashAmount'];
$sendOrRequest = "request";
$note = $_POST['requestNote'];
$fulfilled = 'new';
$response = ' ';
$transationId = ' ';

transaction($sender, $recipient, $amount, $sendOrRequest, $note, $fulfilled, $response, $transationId);
//header("location: index.php");


?>