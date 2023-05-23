<?php

include_once 'db.php';


$sql = "SELECT id FROM people WHERE username=? AND password=(SHA1(?))";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("ss", $username, $password);

$username = trim($_POST['usernameLogin']," ");
$password = $_POST['passwordLogin'];

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc(); //row = id array

$id = $row['id'];

session_start();

$_SESSION['id'] = $id;  

if ($stmt->execute()){
    header("location: index.php");
} else {
    print("error: ".$db->error);
}

?>