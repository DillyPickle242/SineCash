<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>

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
        </div>
        <div id="requestAlerts">
            <?php
            include_once 'getTransactionHistory.php';

            $transactions = getTH();

            foreach ($transactions as $row) {

                $userID = $_SESSION['id'];

                $Unixdate = strtotime($row['time']);
                $date = date('F j, Y, g:i a', $Unixdate);

                if ($row['sender_ID'] == $userID) {
                    $balanceText = $row['senderBalance'];

                    if ($row['sendOrRequest'] == 'allowance') {
                        $text = ("You received $$row[amount] as your allowance");
                    }
                    if ($row['sendOrRequest'] == 'send') {
                        $text = ("You sent $$row[amount] to $row[recipient_username] for $row[note]");
                    }
                    if ($row['sendOrRequest'] == 'request') {
                        if ($row['fulfilled'] == 'sent') {
                            $text = ("You sent $$row[amount] to $row[recipient_username] for $row[note] upon their request");
                        }
                        if ($row['fulfilled'] == 'declined') {
                            $text = ("You declined a $$row[amount] request from $row[recipient_username] for $row[note]");
                        }
                        if ($row['fulfilled'] == 'pending') {
                            $text = ("You have a $$row[amount] pending request from $row[recipient_username] for $row[note]");
                        }
                        if ($row['fulfilled'] == 'taken') {
                            $text = ("$row[recipient_username] took $$row[amount] from you for $row[note]");
                        }
                    }
                }
                if ($row['recipient_ID'] == $userID) {
                    $balanceText = $row['receiverBalance'];
                    if ($row['sendOrRequest'] == 'send') {
                        $text = ("$row[sender_username] sent $$row[amount] to you for $row[note]");
                    }
                    if ($row['sendOrRequest'] == 'request') {
                        if ($row['fulfilled'] == 'sent') {
                            $text = ("$row[sender_username] sent $$row[amount] to you for $row[note] upon your request");
                        }
                        if ($row['fulfilled'] == 'declined') {
                            $text = ("$row[sender_username] declined your $$row[amount] request for $row[note]");
                        }
                        if ($row['fulfilled'] == 'pending') {
                            $text = ("Your $$row[amount] request to $row[sender_username] for $row[note] is pending");
                        }
                        if ($row['fulfilled'] == 'taken') {
                            $text = ("you took $$row[amount] from $row[sender_username] for $row[note]");
                        }
                    }
                }
                if ($text) {
                    print("<div id='requestAlerts'><div class='alert'>$text <div class='exDetails'><div class='transactionBalance'>Balance: $$balanceText</div> <div class='transactionDate'>$date</div></div></div></div>");
                } else {
                    print_r($row);
                }
            }

            ?>








        </div>




    </header>
    <script src="moneyApp.js"></script>
</body>

</html>