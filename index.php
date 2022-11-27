<html>
<head>
    <link rel="stylesheet" href="moneyApp.css?<?php echo time(); ?>">

    <?php 
    include_once 'themes.php';
    include_once 'sessionStart.php';
    include_once 'db.php';
    include_once 'db_allowance.php';
    include_once 'parentCheck.php';

    giveAllowances();
    
    $familyCode = getFamilyCode();
    if (!$familyCode) {
        header("location: loginPage.php");
    }

    
    ?>
</head>
<body>
    <header>
        <div id="topBar">
                <a href="settingsPage.php">
                    <img src="images/settings icon.png" id="settingsButton" class="topMenuItems">
                </a>
                <a href="profilePage.php">
                    <img src="images/familyIcon.png" id="profileButton" class="topMenuItems">
                </a>
                <a href="index.php">
                    <div id="title" class="Atext"> SineCash </div>
                </a>
                
                <?php 
                //crazy sinewaves:
                // for ($x = 0; $x <=23; $x+=1) {
                //     print_r("<img src='animated_favicon.gif' class='sine'>");
                // }
                ?>
                
                
        </div>
    </header>
    <div id="cashTotalContainer">
        <?php 
        //Custom Image

        $sql = "SELECT backgroundImg FROM people WHERE ID=?";
                $stmt = $db->prepare($sql);
                if (!$stmt){
                    print("error: ".$db->error);
                }
                $stmt->bind_param("i", $id);
                $id = $_SESSION['id'];

                if (!$stmt->execute()) {
                    print("execute error: ".$db->error);
                }
                $result = $stmt->get_result();
                $imgRow = $result->fetch_assoc(); //row = totalCash array
                $backgroundFile = $imgRow['backgroundImg'];

        print_r("<img id='cashBackground' src='images\-$backgroundFile.gif'>") 
        
        ?>
        <?php 
                $sql = "SELECT parent FROM people WHERE ID=?";
                $stmt = $db->prepare($sql);
                if (!$stmt){
                    print("error: ".$db->error);
                }
                $stmt->bind_param("i", $id);
                $id = $_SESSION['id'];

                if (!$stmt->execute()) {
                    print("execute error: ".$db->error);
                }
                $result = $stmt->get_result();
                $parentRow = $result->fetch_assoc(); //row = totalCash array
                $parent = $parentRow['parent'];


                if ($parent == '1'){
                    $stmt = $db->prepare("UPDATE `people` SET `totalCash` = 1000000 WHERE `people`.`id` = ?;");
                    $stmt->bind_param("i", $id);

                    // set parameters and execute
                    $id = $_SESSION['id'];
                    if (!$stmt->execute()){
                        print("error: ".$db->error);
                    }

                    $sql = "SELECT familyCode FROM people WHERE ID=?";
                    $stmt = $db->prepare($sql);
                    if (!$stmt){
                        print("error: ".$db->error);
                    }
                    $stmt->bind_param("i", $id);
                    $id = $_SESSION['id'];

                    if (!$stmt->execute()) {
                        print("execute error: ".$db->error);
                    }
                    $result = $stmt->get_result();
                    $familyCodeRow = $result->fetch_assoc();
                    $familyCode = $familyCodeRow['familyCode']; 


                } else {
                    $sql = "SELECT totalCash FROM people WHERE ID=?";
                    $stmt = $db->prepare($sql);
                    if (!$stmt){
                        print("error: ".$db->error);
                    }
                    $stmt->bind_param("i", $id);
                    $id = $_SESSION['id'];

                    if (!$stmt->execute()) {
                        print("execute error: ".$db->error);
                    }
                    $result = $stmt->get_result();
                    $cashRow = $result->fetch_assoc(); //row = totalCash array
                    $totalCash = $cashRow['totalCash']; 
                }
                    
                
        ?>
        <p class=Atext id="totalCashDesc"> <?php 
        if ($parent == '0'){
            print_r("Your total cash is:");
        } 
        if ($parent == '1') {    
            print_r("You have infinite cash! \r\n Your family code is:");
        }
        ?></p>
        <p class=Atext id="totalCashNum"> <?php 
        if ($parent == '0'){
            print_r("$$totalCash");
        } 
        if ($parent == '1') {    
            print_r("$familyCode");
        }

        ?> </p>
    </div>
    <div id="sendReceiveA">
        <a href="sendPage.php">
            <button class="hsButton" id="sendButton"> Send </button>
        </a>
        <a href="requestPage.php">
            <button class="hsButton" id="requestButton"> Request </button>
        </a>
        <a href="transactionHistoryPage.php">
            <button class="hsButton" id="historyButton">Transaction History</button>
        </a>
    </div>
    <div id="requestAlerts"> 
        <?php

            $sql = "SELECT recipient, amount, note, ID FROM transactionhistory WHERE sendOrRequest = 'request' AND sender = ? AND fulfilled = 'pending'";
            $stmt = $db->prepare($sql);
            
            $stmt->bind_param("i", $id);
            $id = $_SESSION['id'];
            if (!$stmt->execute()) {
                print("execute error: ".$db->error);
            }

            


            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $recipient = $row['recipient'];
                $amount = $row['amount'];
                $note = $row['note'];
                $transactionId = $row['ID'];

                $sql = "SELECT username FROM people WHERE ID = ?";
                $stmt = $db->prepare($sql);
                if (!$stmt){
                    print("error: ".$db->error);
                }
                $stmt->bind_param("i", $id);
                $id = $recipient;
                if (!$stmt->execute()) {
                    print("execute error: ".$db->error);
                }
                $result2 = $stmt->get_result();
                $row2 = $result2->fetch_assoc();
                $username = $row2['username'];

                print_r("
                <form action='requestRespond.php' method='post'>
                <div class='alert'> 
                <div>$username is requesting $$amount from you for $note. Would you like to accept? </div>

                <input type='hidden' name='requestNote' value='$note'> </input>
                <input type='hidden' name='requestedAmount' value='$amount'> </input>
                <input type='hidden' name='recipientId' value='$recipient'> </input>
                <input type='hidden' name='transactionId' value='$transactionId'> </input>

                <button class='alertButton' name='response' value='yes'> Yes </button>
                <button class='alertButton' name='response' value='no'> No </button>
                </div>
                </form>
                ");
            }

                
        
        ?>

    </div>

    <script src="moneyApp.js<?php echo time(); ?>"></script>
</body>
</html>