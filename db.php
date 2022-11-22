<?php
function connect(){
    $user='SineCash';
    $password='4icKzWvd2Ndn$Vd';
    return new mysqli("localhost",$user,$password,"sinecash");
}

$db = connect();


$stmt = $db->prepare("SET time_zone = '-5:00';");
$stmt->execute();


mysqli_report(MYSQLI_REPORT_ERROR);
?>