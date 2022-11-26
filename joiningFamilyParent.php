<?php

include_once 'db.php';
include_once 'sessionStart.php';
include_once 'db_people.php';

$sql = "SELECT family FROM people WHERE familyCode = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    print("error: " . $db->error);
}
$stmt->bind_param("s", $familyCode);
$familyCode = $_POST['familyCode'];

if (!$stmt->execute()) {
    print("execute error: " . $db->error);
}
$result = $stmt->get_result();
$familyNameRow = $result->fetch_assoc(); //row = totalCash array
$familyName = $familyNameRow['family'];


if ($familyName) {
    if (familyLocked($familyCode)['familyLocked'] == 0) {
        // prepare and bind
        $stmt = $db->prepare("UPDATE `people` SET `family` = ?, `parent` = 1, familyCode = ? WHERE `people`.`id` = ?;");
        $stmt->bind_param("ssi", $familyName, $familyCode, $id);

        // set parameters and execute
        $familyName;
        $familyCode = $_POST['familyCode'];
        $id = $_SESSION['id'];
        print_r($familyCode);

        if ($stmt->execute()) {
            header("location: index.php");
        } else {
            print("error: " . $db->error);
        }
    } else if (familyLocked($familyCode)['familyLocked'] == 1) {
        print_r("sorry, this family's administrator has locked the family. They can unlock it in the profile page.");
    }
} else {
    print_r("Sorry, the code you entered is incorrect. Please try again.");
}
