<?php
include_once "db.php";
include_once 'sessionStart.php';

function makeDropDown($Excludeid){
    global $db;

    print_r("<option value='?null'>...</option>");
    //gett family code from id
    $sql = "SELECT familyCode FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        print("error: " . $db->error);
    }
    $stmt->bind_param("s", $id);
    $id = $_SESSION['id'];
    //$stmt->bind_param("s", $id);
    //$id = $_SESSION['id'];
    if (!$stmt->execute()) {
        print("execute error: " . $db->error);
    }

    $result = $stmt->get_result();
    $codeRow = $result->fetch_assoc();
    $familyCode = $codeRow['familyCode'];


    $sql = "SELECT username, ID FROM people WHERE familyCode = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        print("error: " . $db->error);
    }
    $stmt->bind_param("s", $familyCode);
    $id = $_SESSION['id'];
    $familyCode = $codeRow['familyCode'];

    if (!$stmt->execute()) {
        print("execute error: " . $db->error);
    }

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $id = $row['ID'];
        if ($id != $Excludeid) {
            print_r("<option value='$id'>$username</option> ");
        }
    }

}
