<?php

include_once 'db.php';


// prepare and bind
$stmt = $db->prepare("INSERT INTO people (password, username, email) VALUES (SHA1(?), ?, ?)");
$stmt->bind_param("sss", $password, $username, $email);

// set parameters and execute
$password = $_POST['passwordCreate'];
$username = $_POST['usernameCreate'];
$email = $_POST['emailCreate'];
if ($stmt->execute()){
    header("location: parentOrChild.php");
} else {
    print("error: ".$db->error);
}


$sql = "SELECT id FROM people WHERE username=? AND password=(SHA1(?))";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("ss", $username, $password);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc(); //row = id array

$id = $row['id'];
print($id);
session_start();

$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$_SESSION['id'] = $id; 







?>