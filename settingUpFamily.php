<?php
include_once 'db.php';
include_once 'sessionStart.php';
include_once 'generateFamilyCode.php';


$sql = "SELECT familyCode FROM people WHERE ID=?";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("i", $id);
$id = $_SESSION['id'];

if (!$stmt->execute()) {
    print("execute error: ".$db->error);
}
$result = $stmt->get_result();
$row = $result->fetch_assoc(); //row = totalCash array
$familyCode = $row['familyCode'];  
if ($familyCode) {
    header("location: index.php");
    exit;
}


// prepare and bind
$stmt = $db->prepare("UPDATE `people` SET `family` = ?, `parent` = 1, familyCode = ? WHERE `people`.`id` = ?;");
$stmt->bind_param("ssi", $family, $familyCode, $id);

// set parameters and execute
$family = $_POST['familyName'];
$id = $_SESSION['id'];
$familyCode = generateFamilyCode();
print_r($familyCode);

if ($stmt->execute()){
    header("location: index.php");
} else {
    print("error: ".$db->error);
}


?>