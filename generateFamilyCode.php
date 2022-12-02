<?php
include_once 'db.php';

function generateRandomString($length = 4)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateFamilyCode()
{
    global $db;
    $sql = "SELECT distinct familyCode FROM people WHERE familyCode = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $code);
    $code = generateRandomString();

    $stmt->execute();
    $result = $stmt->get_result();
    $output = $result->fetch_assoc();

    if($output){
        return generateFamilyCode();
    } else {
        return $code;
    }
}
