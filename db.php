<?php
function connect(){
    $user='SineCash';
    $password='4icKzWvd2Ndn$Vd';
    return new mysqli("localhost",$user,$password,"sinecash");
}

$db = connect();

$db("SET time_zone = '-5:00'")->execute();

mysqli_report(MYSQLI_REPORT_ERROR);
?>