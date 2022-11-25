<?php

include_once 'db.php';
include_once 'sessionStart.php';
include_once 'db_allowance.php';

print_r($_POST);
$allowanceAmount = getAllowanceInfo($_POST['id']);

// setting basics
$stmt = $db->prepare("UPDATE allowance SET amount = ?, frequency = ?, nextTimeGiven = ? WHERE id = ?;");
$stmt->bind_param("diii", $amount, $frequency, $nextTimeGiven, $childID);

print_r($amount);
// set parameters and execute
if($_POST['amount']){
    $amount = $_POST['amount'];
} else {
    $amount = $allowanceAmount['amount'];
}

$frequency = $_POST['frequency'];
$nextTimeGiven = strtotime($_POST['DOW']);
$childID = $_POST['id'];

if (!$stmt->execute()){
    print("error: ".$db->error);
}



header('location: index.php');

    