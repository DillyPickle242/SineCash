<?php
function connect(){
    $user='SineCash';
    $password='4icKzWvd2Ndn$Vd';
    return new mysqli("localhost",$user,$password,"sinecash");
}

$db = connect();

mysqli_report(MYSQLI_REPORT_ERROR);
?>