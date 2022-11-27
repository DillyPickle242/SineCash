<?php
include_once "db.php";

function email($transactionId){
    include_once "db_people.php";
    //email from id
    global $db;

    function emailFromId($id){
        global $db;
        $sql = "SELECT email FROM people WHERE ID = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['email'];
    }
    

    $sql = "SELECT sender, recipient, amount, note, `time`, fulfilled, sendOrRequest, senderBalance, receiverBalance FROM transactionhistory WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();


    $sender = $row['sender'];
    $recipient = $row['recipient'];
    $recipientUsername = getNameFromId($recipient)['username'];
    $senderUsername = getNameFromId($sender)['username'];
    $amount = $row['amount'];
    $note = $row['note'];
    $time = $row['time'];
    $fulfilled = $row['fulfilled'];
    $sendOrRequest = $row['sendOrRequest'];
    $senderBalance = $row['senderBalance'];
    $recipientBalance = $row['receiverBalance'];

    $senderEmail = emailFromId($sender);
    $recipientEmail = emailFromId($recipient);

    $senderParent = parentFromId($sender)['parent'];
    $recipientParent = parentFromId($recipient)['parent'];


    if ($sender == $sender) {
        if ($sendOrRequest == 'allowance') {
            $senderSubject = ("You received $$amount as your allowance");
        }
        if ($sendOrRequest == 'send') {
            $senderSubject = ("You sent $$amount to $recipientUsername for '$note'");
        }
        if ($sendOrRequest == 'request') {
            if ($fulfilled == 'sent') {
                $senderSubject = ("You sent $$amount to $recipientUsername for '$note' upon their request");
            }
            if ($fulfilled == 'declined') {
                $senderSubject = ("You declined a $$amount request from $recipientUsername for '$note'");
            }
            if ($fulfilled == 'pending') {
                $senderSubject = ("You have a $$amount pending request from $recipientUsername for '$note'");
            }
            if ($fulfilled == 'taken') {
                $senderSubject = ("$recipientUsername took $$amount from you for '$note'");
            }
        }
    }
    if ($recipient == $recipient) {
        if ($sendOrRequest == 'send') {
            $recipientSubject = ("$senderUsername sent $$amount to you for '$note'");
        }
        if ($sendOrRequest == 'request') {
            if ($fulfilled == 'sent') {
                $recipientSubject = ("$senderUsername sent $$amount to you for '$note' upon your request");
            }
            if ($fulfilled == 'declined') {
                $recipientSubject = ("$senderUsername declined your $$amount request for ''$note''");
            }
            if ($fulfilled == 'pending') {
                $recipientSubject = ("Your $$amount request to $senderUsername for '$note' is pending");
            }
            if ($fulfilled == 'taken') {
                $recipientSubject = ("You took $$amount from $senderUsername for '$note'");
            }
        }
    }
    
    //mail sender
    if ($senderParent == 0){
        $senderText = "Hello $senderUsername, $senderSubject and your total cash is now $$senderBalance. Visit https://sinecash.fm7.net/ to get more info";
    } else {
        $senderText = "Hello $senderUsername, $senderSubject. Visit https://sinecash.fm7.net/ to get more info";
    }

    if ($sendOrRequest == 'request'){
        if ($fulfilled != 'sent' && $fulfilled != 'declined'){
            mail($senderEmail, $senderSubject, $senderText, 'From: sinecash@d1.fm7.net');
            print_r("<div>to $senderEmail</div><div>$senderSubject</div><div> $senderText </div>");
        }
    } else if ($sendOrRequest == 'allowance'){
        mail($senderEmail, $senderSubject, $senderText, 'From: sinecash@d1.fm7.net');
        print_r("<div>to $senderEmail</div><div>$senderSubject</div><div> $senderText </div>");
    }
    

    //mail recipient
    if ($recipientParent == 0){
        $recipientText = "Hello $recipientUsername, $recipientSubject and your total cash is now $$recipientBalance. Visit https://sinecash.fm7.net/ to get more info";
    } else {
        $recipientText = "Hello $recipientUsername, $recipientSubject. Visit https://sinecash.fm7.net/ to get more info";
    }

    if ($sendOrRequest == 'request'){
        if ($fulfilled == 'sent' or $fulfilled == 'declined'){
            mail($recipientEmail,$recipientSubject, $recipientText, 'From: sinecash@d1.fm7.net');
            print_r("<div>to $recipientEmail</div><div>$recipientSubject</div><div> $recipientText </div>");
        }
    } else if ($sendOrRequest == 'send'){
        mail($recipientEmail, $recipientSubject, $recipientText, 'From: sinecash@d1.fm7.net');
        print_r("<div>to $recipientEmail</div><div>$recipientSubject</div><div> $recipientText </div>");
    }
    

}