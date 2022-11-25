<?php
include_once 'db.php';
include_once 'sessionStart.php';


function getTH(){
    global $db;

    $sql = "SELECT people_sender.username AS sender_username, 
    people_recipient.username AS recipient_username, 
    people_sender.ID AS sender_ID, people_recipient.ID AS recipient_ID, 
    transactionhistory.amount, 
    `time`, fulfilled, 
    transactionhistory.ID AS transaction_ID, 
    note, sendOrRequest, senderBalance, receiverBalance
    FROM `transactionhistory`, 
    `people` AS `people_sender`,
    `people` AS `people_recipient` 
    WHERE `sender` = `people_sender`.`ID` 
    AND `recipient` = `people_recipient`.`ID` AND (sender = ? OR recipient = ?)
    ORDER BY `transactionhistory`.`time` DESC";
    $stmt = $db->prepare($sql);
    if (!$stmt){
        print("error: ".$db->error);
    }
    $stmt->bind_param("ii", $id, $id);
    $id = $_SESSION['id'];
    if (!$stmt->execute()) {
        print("execute error: ".$db->error);
    }

    $result = $stmt->get_result();
    $ret = array();
    while ($row = $result->fetch_assoc()) {
        $ret[] = $row;
    }
    return $ret;
}
