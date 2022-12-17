<?php
include_once 'db.php';
include_once 'sessionStart.php';
include_once 'mail.php';


$stmt = $db->prepare("INSERT INTO promiseCards (sender, recipient, title, `description`, count) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $sender, $recipient, $title, $description, $count);

$sender = $_SESSION['id'];
$recipient = $_POST['cardPersonSelect'];
$title = $_POST['cardTitle'];
$description = $_POST['cardDescription'];
$count = $_POST['cardCount'];

$stmt->execute();
$PCid = $stmt->insert_id;
email($PCid,'PC');

$db->commit();

header('location: index.php');