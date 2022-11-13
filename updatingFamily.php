<?php

include_once 'db.php';
include_once 'sessionStart.php';

print_r($_POST);

foreach($_POST['data'] as $childID => $childSettings){

        // setting basics
    $stmt = $db->prepare("UPDATE allowance SET amount = ?, frequency = ?, nextTimeGiven = ? WHERE id = ?;");
    $stmt->bind_param("diii", $amount, $frequency, $nextTimeGiven, $childID);

    // set parameters and execute
    if($childSettings['allowanceAmount'] == 0){
        $amount = $amount;
    } else if ($childSettings['allowanceAmount'] > 0) {
        $amount = $childSettings['allowanceAmount'];
    }
    
    $frequency = $childSettings['allowanceFrequency'];
    $nextTimeGiven = strtotime($childSettings['datePick']);

    if (!$stmt->execute()){
        print("error: ".$db->error);
    }


}

header('location: index.php');

    