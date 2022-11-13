<?php
include_once 'sessionStart.php';
include_once 'db.php';
$stmt = $db->prepare("UPDATE `people` SET `backgroundImg` = ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("si", $backgroundImg, $id);

    print_r($_POST);
    // set parameters and execute
    $backgroundImg = $_POST['backgroundImg'];
    $id = $_SESSION['id'];

    if ($stmt->execute()){
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }