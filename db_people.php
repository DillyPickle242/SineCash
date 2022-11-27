<?php

include_once 'sessionStart.php';
include_once 'db.php';
include_once 'mail.php';

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

function getTotalCashFromId($id)
{
    global $db;
    $sql = "SELECT totalCash FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function familyLocked($familyCode)
{
    global $db;
    $sql = "SELECT familyLocked FROM people WHERE familyCode = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $familyCode);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function parentFromId($id)
{
    global $db;
    $sql = "SELECT parent FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function emailFromId($id)
{
    global $db;
    $sql = "SELECT email FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['email'];
}


function transaction($sender, $recipient, $amount, $sendOrRequest, $note, $fulfilled, $response, $transactionId)
{
    global $db;
    $senderTotalCash = getTotalCashFromId($sender)['totalCash'];

    //SEND
    if ($sendOrRequest == 'send' && $amount <= $senderTotalCash) {
        $db->begin_transaction();
        try {
            //adding cash to the receiver
            $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` + ? WHERE `people`.`id` = ?;");
            $stmt->bind_param("di", $amount, $recipient);
            $stmt->execute();

            //removing cash from sender
            $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
            $stmt->bind_param("di", $amount, $sender);
            $stmt->execute();

            //setting transaction history
            $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iidsssdd", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance);
            $fulfilled = 'sent';
            $senderBalance = getTotalCashFromId($sender)['totalCash'];
            $receiverBalance = getTotalCashFromId($recipient)['totalCash'];
            $stmt->execute();
            //sending email based on transactionHistory
            $THid = $stmt->insert_id;
            email($THid);

            $db->commit();
        } catch (mysqli_sql_exception $exception) {
            $db->rollback();
            throw $exception;
        }
    } else if ($sendOrRequest == 'send' && $amount > $senderTotalCash){
        header("location: notEnoughMoney.html");
    }


    //REQUEST
    //brand new request
    if ($sendOrRequest == 'request' && $fulfilled == 'new' && parentFromId($recipient)['parent'] == '0') {
        $db->begin_transaction();
        try {
            //setting transaction history
            $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iidsssdd", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance);
            $fulfilled = 'pending';
            $senderBalance = getTotalCashFromId($sender)['totalCash'];
            $receiverBalance = getTotalCashFromId($recipient)['totalCash'];
            $stmt->execute();
            //sending email based on transactionHistory
            $THid = $stmt->insert_id;
            email($THid);

            $db->commit();
        } catch (mysqli_sql_exception $exception) {
            $db->rollback();
            throw $exception;
        }

        //request response
    } else if ($sendOrRequest == 'request' && $fulfilled == 'pending') {
        //for yes
        if ($response == 'yes') {
            if ($amount <= $senderTotalCash) {
                $db->begin_transaction();
                try {
                    //giving the person their money:
                    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` + ? WHERE `people`.`ID` = ?;");
                    $stmt->bind_param("di", $amount, $recipient);
                    $stmt->execute();

                    //taking away your money
                    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
                    $stmt->bind_param("di", $amount, $sender);
                    $stmt->execute();

                    //setting transaction to sent
                    $stmt = $db->prepare("UPDATE `transactionhistory` SET `fulfilled` = 'sent', `senderBalance` = ?, `receiverBalance` = ?, `time` = NOW() WHERE `transactionhistory`.`ID` = ?;");
                    $stmt->bind_param("ddi", $senderBalance, $receiverBalance, $transactionId);
                    $senderBalance = getTotalCashFromId($_SESSION['id'])['totalCash'];
                    $receiverBalance = getTotalCashFromId($_POST['recipientId'])['totalCash'];
                    $stmt->execute();

                    email($_POST['transactionId']);
                    $db->commit();
                } catch (mysqli_sql_exception $exception) {
                    $db->rollback();
                    throw $exception;
                }
            } else if ($sendOrRequest == 'request' && $amount > $senderTotalCash && $fulfilled == 'pending'){
                header("location: notEnoughMoney.html");
            }
        }
        //for no
        if ($response == 'no') {
            //setting transaction to declined
            $stmt = $db->prepare("UPDATE `transactionhistory` SET `fulfilled` = 'declined', senderBalance = ?, receiverBalance = ?,  `time` = NOW() WHERE `transactionhistory`.`ID` = ?;");
            $stmt->bind_param("ddi", $senderBalance, $receiverBalance, $transactionId);
            $senderBalance = getTotalCashFromId($sender)['totalCash'];
            $receiverBalance = getTotalCashFromId($recipient)['totalCash'];
            if(!$stmt->execute()){
                print("error: " . $db->error);
            }
            email($transactionId);
        }
        //if requester is a parent
    } else if ($sendOrRequest == 'request' && $fulfilled == 'new' && parentFromId($recipient)['parent'] == '1') {
        $db->begin_transaction();
        try {
            //removing cash from child
            $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
            $stmt->bind_param("di", $amount, $sender);
            $stmt->execute();

            //setting transaction history
            $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iidsssdd", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance);
            $fulfilled = 'taken';
            $senderBalance = getTotalCashFromId($sender)['totalCash'];
            $receiverBalance = 0;
            $stmt->execute();
            //sending email based on transactionHistory
            $THid = $stmt->insert_id;
            email($THid);

            $db->commit();
        } catch (mysqli_sql_exception $exception) {
            $db->rollback();
            throw $exception;
        }
    }
}
