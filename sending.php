<?php
include_once 'sessionStart.php';
include_once 'db_people.php';

$sender = $_SESSION['id'];
$recipient = $_POST['sendPersonSelect'];
$amount = $_POST['sendCashAmount'];
$sendOrRequest = "send";
$note = $_POST['sendNote'];
$fulfilled = 'sent';
$response = ' ';
$transationId = ' ';

transaction($sender, $recipient, $amount, $sendOrRequest, $note, $fulfilled, $response, $transationId);
header("Location: index.php?transaction=true");

