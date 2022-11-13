<?php
include_once 'db.php';

$sql = "SELECT parent FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt){
        print("error: ".$db->error);
    }
    $stmt->bind_param("s", $id);
    $id = $_SESSION['id'];
    //$stmt->bind_param("s", $id);
    //$id = $_SESSION['id'];
    if (!$stmt->execute()) {
        print("execute error: ".$db->error);
    }

    $result = $stmt->get_result();
    $parentRow = $result->fetch_assoc();
    $parent = $parentRow['parent'];

