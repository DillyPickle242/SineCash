<?php 
include_once 'sessionStart.php';
include_once 'db_people.php';

$sender = $_SESSION['id'];
$recipient = $_POST['recipientId'];
$amount = $_POST['requestedAmount'];
$sendOrRequest = "request";
$note = $_POST['requestNote'];
$fulfilled = 'pending';
$response = $_POST['response'];
$transactionId = $_POST['transactionId'];

transaction($sender, $recipient, $amount, $sendOrRequest, $note, $fulfilled, $response, $transactionId);
header("location: index.php");
?>