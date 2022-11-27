<?php

include_once 'sessionStart.php';

function getChildInfo($familyCode)
{
    global $db;
    $sql = "SELECT username, ID, totalCash FROM people WHERE familyCode = ? AND parent = 0";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $familyCode);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getFamilyCode()
{
    global $db;
    $sql = "SELECT familyCode FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $id = $_SESSION['id'];
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['familyCode'];
}

function idsFromFamilyCode($familyCode)
{
    global $db;
    $sql = "SELECT ID FROM people WHERE familyCode = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $familyCode);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return array_map(function ($row) {
        return $row['ID'];
    }, $rows);
}

function getNameFromId($id)
{
    global $db;
    $sql = "SELECT username FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getTotalCashFromId($id) {
    global $db;
    $sql = "SELECT totalCash FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function familyLocked($familyCode){
    global $db;
    $sql = "SELECT familyLocked FROM people WHERE familyCode = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $familyCode);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function parentFromId($id){
    global $db;
    $sql = "SELECT parent FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function updateAllowancePeople($allowAmount, $id)
{
    global $db;
    include_once 'mail.php';

    // changign the recievers cash amount
    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash`+? WHERE `people`.`id` = ?;");
    $stmt->bind_param("di", $allowAmount, $id);
    if ($stmt->execute()) {

        // setting transaction history
        $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidsss", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest);

        $sender = $id;
        $recipient = $id;
        $amount = $allowAmount;
        $note = 'your allowance';
        $fulfilled = 'sent';
        $sendOrRequest = "allowance";

        $stmt->execute();
        $THid = $stmt->insert_id;
        email($THid);
    }
}
