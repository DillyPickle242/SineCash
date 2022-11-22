<?php


print_r($_POST);

include_once 'db.php';
include_once 'sessionStart.php';

$sql = "SELECT totalCash FROM people WHERE ID=?";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("i", $id);
$id = $_SESSION['id'];

$stmt->execute();
$result = $stmt->get_result();
$cashRow = $result->fetch_assoc(); //row = totalCash array
$totalCash = $cashRow['totalCash'];  

$sentCashAmount = $_POST['sendCashAmount'];

if ($sentCashAmount <= $totalCash) {
    // prepare and bind
    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` + ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("di", $sentCashAmount, $id);

    // set parameters and execute
    $sentCashAmount = $_POST['sendCashAmount'];
    $id = $_POST['sendPersonSelect'];
    $sendNote = $_POST['sendNote'];
    if (!$stmt->execute()){
        print("error: ".$db->error);
    }

    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("di", $sentCashAmount, $id);

    $sentCashAmount = $_POST['sendCashAmount'];
    $id = $_SESSION['id'];
    if ($stmt->execute()){
        //header("location: index.php");
    } else {
        print("error: ".$db->error);
    }

    // prepare and bind
    $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidsss", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest);

    // set parameters and execute
    $sender = $_SESSION['id'];
    $recipient = $_POST['sendPersonSelect'];
    $amount = $_POST['sendCashAmount'];
    $note = $_POST['sendNote'];
    $fulfilled = 'sent';
    $sendOrRequest = "send";

    if ($stmt->execute()){
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }

} else {
    header("location: notEnoughMoney.html");
}


?>