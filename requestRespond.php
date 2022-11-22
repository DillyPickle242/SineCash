<?php 
include_once 'db.php';
include_once 'sessionStart.php';


print_r($_POST);
$responce = $_POST['button'];


$sql = "SELECT totalCash FROM people WHERE ID=?";
$stmt = $db->prepare($sql);
if (!$stmt){
    print("error: ".$db->error);
}
$stmt->bind_param("i", $id);
$id = $_SESSION['id'];

$stmt->execute();
$result = $stmt->get_result();
$cashRow = $result->fetch_assoc(); //row = totalCash array
$totalCash = $cashRow['totalCash'];  

print_r($responce);
if ($responce == 'yes'){

    $requestedAmount = $_POST['requestedAmount'];
    if ($requestedAmount <= $totalCash) {
    //giving the person their money:
        // prepare and bind
        $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` + ? WHERE `people`.`ID` = ?;");
        $stmt->bind_param("di", $requestedAmount, $recipientId);
    
        // set parameters and execute
        $requestedAmount = $_POST['requestedAmount'];
        $recipientId = $_POST['recipientId'];
        if (!$stmt->execute()){
            print("error: ".$db->error);
        }
    
    //taking away your money
        $stmt = $db->prepare("UPDATE `people` SET `totalCash` = `totalCash` - ? WHERE `people`.`id` = ?;");
        $stmt->bind_param("di", $requestedAmount, $id);
    
        $requestedAmount = $_POST['requestedAmount'];
        $id = $_SESSION['id'];
        if ($stmt->execute()){
            //header("location: index.php");
        } else {
            print("error: ".$db->error);
        }
        
        //setting transaction to sent
        $stmt = $db->prepare("UPDATE `transactionhistory` SET `fulfilled` = 'sent' WHERE `transactionhistory`.`ID` = ?;");
        $stmt->bind_param("i", $transactionId);

        $transactionId = $_POST['transactionId'];
        if ($stmt->execute()){
            header("location: index.php");
        } else {
            print("error: ".$db->error);
        }

        
        } else {
            header("location: notEnoughMoney.html");
        }

} 
if($responce == 'no') {
    //setting transaction to declined
    $stmt = $db->prepare("UPDATE `transactionhistory` SET `fulfilled` = 'declined' WHERE `transactionhistory`.`ID` = ?;");
    $stmt->bind_param("i", $transactionId);

    $transactionId = $_POST['transactionId'];
    if ($stmt->execute()){
        header("location: index.php");
    } else {
        print("error: ".$db->error);
    }
}

?>