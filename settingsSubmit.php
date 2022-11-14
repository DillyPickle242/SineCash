<?php
include_once 'sessionStart.php';
include_once 'db.php';
$stmt = $db->prepare("UPDATE `people` SET `backgroundImg` = ?, `defaultTheme` = ? WHERE `people`.`id` = ?;");
    $stmt->bind_param("sii", $backgroundImg, $defaultTheme, $id);

    print_r($_POST);
    // set parameters and execute
    $backgroundImg = $_POST['backgroundImg'];
    if ($_POST['defaultTheme'] == 1){
        $defaultTheme = 1;
    } else {
        $defaultTheme = 0;
    }
    
    $id = $_SESSION['id'];

    if ($stmt->execute()){
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }