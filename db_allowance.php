<?php

function getAllowanceInfo($id)
{
    global $db;
    $sql = "SELECT frequency, amount, nextTimeGiven FROM allowance WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        return $row;
    } else {
        include_once 'parentCheck.php';
        allowanceDefaults($id, $parent);
        return getAllowanceInfo($id);
    }
}

function allowanceDefaults($id, $parent)
{
    if ($parent == 0) {
        global $db;
        $stmt = $db->prepare("INSERT INTO allowance (ID, frequency, amount, nextTimeGiven) VALUES (?, 0, 0, UNIX_TIMESTAMP())");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}


function giveAllowances()
{

    global $db;
    include_once 'db_people.php';

    //getting places where nextTimeGiven < unix timestamp
    $sql = "SELECT frequency, amount, nextTimeGiven, ID FROM allowance WHERE nextTimeGiven < UNIX_TIMESTAMP()";
    $stmt = $db->prepare($sql);

    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        $allowFrequency = $row['frequency'];
        $allowAmount = $row['amount'];
        $id = $row['ID'];
        $nextTimeGiven = $row['nextTimeGiven'];

        if ($allowFrequency > 0) {
            if ($allowAmount > 0) {
                include_once 'mail.php';

                $db->begin_transaction();
                try {
                    // changign the recievers cash amount
                    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash`+? WHERE `people`.`id` = ?;");
                    $stmt->bind_param("di", $allowAmount, $id);
                    $stmt->execute();

                    // setting transaction history
                    $stmt = $db->prepare("INSERT INTO transactionhistory (sender, recipient, amount, note, fulfilled, sendOrRequest, senderBalance, receiverBalance, `time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("iidsssdds", $sender, $recipient, $amount, $note, $fulfilled, $sendOrRequest, $senderBalance, $receiverBalance, $time);

                    $sender = $id;
                    $recipient = $id;
                    $amount = $allowAmount;
                    $note = 'your allowance';
                    $fulfilled = 'sent';
                    $sendOrRequest = "allowance";
                    $senderBalance = 0;
                    $receiverBalance = getTotalCashFromId($recipient)['totalCash'];
                    $time = gmdate("Y-m-d h:i:s", $nextTimeGiven);

                    $stmt->execute();
                    $THid = $stmt->insert_id;
                    email($THid);

                    $stmt = $db->prepare("UPDATE allowance SET nextTimeGiven = nextTimeGiven + ? WHERE ID = ?;");
                    $stmt->bind_param("ii", $unixFrequency, $id);
                    $unixFrequency = $allowFrequency * 60 * 60 * 24;
                    $stmt->execute();

                    $db->commit();
                } catch (mysqli_sql_exception $exception) {
                    $db->rollback();
                    throw $exception;
                }
            }
        }
    }
}
