<?php


print_r($_POST);

include_once 'db.php';
include_once 'sessionStart.php';
include_once 'db_people.php';
include_once 'mail.php';

$sql = "SELECT parent FROM people WHERE ID=?";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("i", $id);
$id = $_SESSION['id'];

if (!$stmt->execute()) {
    print("execute error: ".$db->error);
}
$result = $stmt->get_result();
$parentRow = $result->fetch_assoc(); //row = totalCash array
$parent = $parentRow['parent'];


if ($parent == "0") {
    // prepare and bind
    $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidsssdd", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance);

    // set parameters and execute
    $sender = $_POST['requestPersonSelect']; //sender is the person you sequest from
    $recipient = $_SESSION['id']; //recipient is the person who send the request
    $amount = $_POST['requestCashAmount'];
    $note = $_POST['requestNote'];
    $fulfilled = 'pending';
    $sendOrRequest = "request";
    $senderBalance = getTotalCashFromId($sender)['totalCash'];
    $receiverBalance = getTotalCashFromId($recipient)['totalCash'];
    if ($stmt->execute()){
        $THid = $stmt->insert_id;
        email($THid);
        
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }
}
if ($parent == "1") {
    //removing money from someones account if you are a parent
    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("di", $sentCashAmount, $id);

    $sentCashAmount = $_POST['requestCashAmount'];
    $id = $_POST['requestPersonSelect'];
    
    if ($stmt->execute()){
        //header("location: index.php");
    } else {
        print("error: ".$db->error);
    }

    // prepare and bind
    $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iidsssdd", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance);

    // set parameters and execute
    $sender = $_POST['requestPersonSelect'];
    $recipient = $_SESSION['id'];
    $amount = $_POST['requestCashAmount'];
    $note = $_POST['requestNote'];
    $fulfilled = 'taken';
    $sendOrRequest = "request";
    $senderBalance = getTotalCashFromId($sender)['totalCash'];
    $receiverBalance = getTotalCashFromId($recipient)['totalCash'];

    if ($stmt->execute()){
        $THid = $stmt->insert_id;
        email($THid);

        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }

}





?>