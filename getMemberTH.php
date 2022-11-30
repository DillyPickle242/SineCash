<?php
include_once 'db.php';
include_once 'sessionStart.php';

function getTH($id, $filtered, $transactionType){
    global $db;

    if($filtered == 'no'){
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
        $stmt->bind_param("ii", $id, $id);
        $id;
        $stmt->execute();
        $result = $stmt->get_result();
        $ret = array();
        while ($row = $result->fetch_assoc()) {
            $ret[] = $row;
        }
        return $ret;
    }

    if($filtered == 'yes'){
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
        WHERE 
        `sendOrRequest` = ? 
        AND `sender` = `people_sender`.`ID` 
        AND `recipient` = `people_recipient`.`ID` 
        AND (sender = ? OR recipient = ?)
        ORDER BY `transactionhistory`.`time` DESC";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("sii",$transactionType ,$id, $id);
        
        $id;
        $stmt->execute();
        $result = $stmt->get_result();
        $ret = array();
        while ($row = $result->fetch_assoc()) {
            $ret[] = $row;
        }
        return $ret;
    }
    
    
}