<?php

include_once 'db.php';
include_once 'sessionStart.php';

$sql = "SELECT family FROM people WHERE familyCode = ?";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("s", $familyCode);
$familyCode = $_POST['familyCode'];

if (!$stmt->execute()) {
    print("execute error: ".$db->error);
}
$result = $stmt->get_result();
$familyNameRow = $result->fetch_assoc(); //row = totalCash array
$familyName = $familyNameRow['family'];


if($familyName) {
    // prepare and bind
    $stmt = $db->prepare("UPDATE `people` SET `family` = ?, `parent` = 1, familyCode = ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("ssi", $familyName, $familyCode, $id);

    // set parameters and execute
    $familyName;
    $familyCode = $_POST['familyCode'];
    $id = $_SESSION['id'];
    print_r($familyCode);

    if ($stmt->execute()){
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }
   
} else {
    print_r("Sorry, the code you entered is incorrect. Please try again.");
}
    