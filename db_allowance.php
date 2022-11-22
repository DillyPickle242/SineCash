<?php

function getAllowanceInfo($id)
{
    global $db;
    $sql = "SELECT frequency, amount, nextTimeGiven FROM allowance WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        return $row;
    } else {
        include_once 'parentCheck.php';
        allowanceDefaults($id, $parent);
        return getAllowanceInfo($id);
    }
}

function allowanceDefaults($id, $parent)
{
    if ($parent == 0) {
        global $db;
        $stmt = $db->prepare("INSERT INTO allowance (ID, frequency, amount, nextTimeGiven) VALUES (?, 0, 0, UNIX_TIMESTAMP())");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}


function giveAllowances()
{

    global $db;
    include_once 'db_people.php';

    //getting places where nextTimeGiven < unix timestamp
    $sql = "SELECT frequency, amount, nextTimeGiven, ID FROM allowance WHERE nextTimeGiven < UNIX_TIMESTAMP()";
    $stmt = $db->prepare($sql);

    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        $allowFrequency = $row['frequency'];
        $allowAmount = $row['amount'];
        $allowNextTimeGiven = $row['nextTimeGiven'];
        $id = $row['ID'];

        if($allowFrequency > 0){
            if($allowAmount > 0){
                updateAllowancePeople($allowAmount, $id);
                updateAllowanceNTS($allowFrequency,$id);
            }
        } 
    }
}

function updateAllowanceNTS($allowFrequency,$id){
    global $db;

    $stmt = $db->prepare("UPDATE allowance SET nextTimeGiven = nextTimeGiven + ? WHERE ID = ?;");
    $stmt->bind_param("ii", $unixFrequency, $id);
    $unixFrequency = $allowFrequency * 60 * 60 * 24;

    $stmt->execute();
}