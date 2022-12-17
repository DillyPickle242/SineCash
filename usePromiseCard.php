<?php
include_once 'db.php';
include_once 'sessionStart.php';
include_once 'mail.php';


$stmt = $db->prepare("UPDATE promiseCards SET count = count - 1 WHERE ID = ?;");
    $stmt->bind_param("i", $cardId);
    $cardId = $_POST['cardId'];
    if (!$stmt->execute()) {
        print("error: " . $db->error);
    } else {
        email($cardId,'PCU');
        header("location: promiseCards.php");
    }
