<?php
include_once 'db.php';
include_once 'db_people.php';

if ($_POST['lockedCheck'] == 'yes') {

    $stmt = $db->prepare("UPDATE `people` SET `familyLocked` = '1' WHERE `familyCode` = ?;");
    $stmt->bind_param("s", $familyCode);
    $familyCode = getFamilyCode();
    if (!$stmt->execute()) {
        print("error: " . $db->error);
    } else {
        header("location: profilePage.php");
    }
} else {

    $stmt = $db->prepare("UPDATE `people` SET `familyLocked` = '0' WHERE `familyCode` = ?;");
    $stmt->bind_param("s", $familyCode);
    $familyCode = getFamilyCode();
    if (!$stmt->execute()) {
        print("error: " . $db->error);
    } else {
        header("location: profilePage.php");
    }
}
