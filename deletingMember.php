<?php
include_once 'db.php';
include_once 'parentCheck.php';
if ($parent = 1){
    //delete person
$stmt = $db->prepare("DELETE FROM people WHERE `people`.`ID` = ?;");
$stmt->bind_param("i", $id);
$id = $_POST['deletedMember'];
if (!$stmt->execute()) {
    print("error: " . $db->error);
}
//delete their transactions
$stmt = $db->prepare("DELETE FROM transactionhistory WHERE `transactionhistory`.`sender` = ?;");
$stmt->bind_param("i", $id);
$id = $_POST['deletedMember'];
if (!$stmt->execute()) {
    print("error: " . $db->error);
}
$stmt = $db->prepare("DELETE FROM transactionhistory WHERE `transactionhistory`.`recipient` = ?;");
$stmt->bind_param("i", $id);
$id = $_POST['deletedMember'];
if (!$stmt->execute()) {
    print("error: " . $db->error);
}
//delete their allowance
$stmt = $db->prepare("DELETE FROM allowance WHERE `allowance`.`ID` = ?;");
$stmt->bind_param("i", $id);
$id = $_POST['deletedMember'];
if (!$stmt->execute()) {
    print("error: " . $db->error);
}
header("location: profilePage.php");

} else {
    print_r("You aren't a parent. You cannot delete people.");
}
