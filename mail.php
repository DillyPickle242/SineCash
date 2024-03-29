<?php
include_once "db.php";

function email($transactionId, $type = 'TH')
{
    global $db;
    include_once "db_people.php";

    if ($type == 'PC' || $type == 'PCU') {
        $sql = "SELECT sender, recipient, title, `description`, count FROM promiseCards WHERE ID = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        $sender = $row['sender'];
        $recipient = $row['recipient'];
        $recipientUsername = getNameFromId($recipient)['username'];
        $senderUsername = getNameFromId($sender)['username'];
        $title = $row['title'];
        $description = $row['description'];
        $count = $row['count'];

        $senderEmail = emailFromId($sender);
        $recipientEmail = emailFromId($recipient);

        if ($type == 'PC') {
            if ($count == 1) {
                $subject = "$senderUsername sent you a promise card!";
            } else {
                $subject = "$senderUsername sent you $count promise cards!";
            }

            if ($count == 1) {
                $text = "You recieived a promise card from $senderUsername. Go to sinecash.fm7.net/promiseCards.php to view your card!";
            } else {
                $text = "You recieived $count promise cards from $senderUsername. Go to sinecash.fm7.net/promiseCards.php to view your cards!";
            }
            mail($recipientEmail, $subject, $text, 'From: sinecash@d1.fm7.net');
        } else if ($type == 'PCU') {
            $subject = "$recipientUsername used a card!";
            $text = "$recipientUsername used a '$title' card! Check out sinecash.fm7.net/transactionHistoryPage.php for more info";
            mail($senderEmail, $subject, $text, 'From: sinecash@d1.fm7.net');
        }

        
    } else if ($type == 'TH') {
        //email from id

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
            if ($row['sendOrRequest'] == 'allowance') {
                $recipientSubject = ("You received $$amount as your allowance");
            }
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
        if ($senderParent == 0) {
            $senderText = "Hello $senderUsername, $senderSubject and your total cash is now $$senderBalance. Visit https://sinecash.fm7.net/ to get more info";
        } else {
            $senderText = "Hello $senderUsername, $senderSubject. Visit https://sinecash.fm7.net/ to get more info";
        }

        if ($sendOrRequest == 'request') {
            if ($fulfilled != 'sent' && $fulfilled != 'declined') {
                mail($senderEmail, $senderSubject, $senderText, 'From: sinecash@d1.fm7.net');
                //print_r("<div>to $senderEmail</div><div>$senderSubject</div><div> $senderText </div>");
            }
        } else if ($sendOrRequest == 'allowance') {
            mail($senderEmail, $senderSubject, $senderText, 'From: sinecash@d1.fm7.net');
            //print_r("<div>to $senderEmail</div><div>$senderSubject</div><div> $senderText </div>");
        }


        //mail recipient
        if ($recipientParent == 0 && $sendOrRequest != 'allowance') {
            $recipientText = "Hello $recipientUsername, $recipientSubject and your total cash is now $$recipientBalance. Visit https://sinecash.fm7.net/ to get more info";
        } else {
            $recipientText = "Hello $recipientUsername, $recipientSubject. Visit https://sinecash.fm7.net/ to get more info";
        }

        if ($sendOrRequest == 'request') {
            if ($fulfilled == 'sent' or $fulfilled == 'declined') {
                mail($recipientEmail, $recipientSubject, $recipientText, 'From: sinecash@d1.fm7.net');
                //print_r("<div>to $recipientEmail</div><div>$recipientSubject</div><div> $recipientText </div>");
            }
        } else if ($sendOrRequest == 'send') {
            mail($recipientEmail, $recipientSubject, $recipientText, 'From: sinecash@d1.fm7.net');
            //print_r("<div>to $recipientEmail</div><div>$recipientSubject</div><div> $recipientText </div>");
        }
    }
}
