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
            include_once 'getMemberTH.php';
            include_once 'parentCheck.php';
            include_once 'db_people.php';

            $transactions = getTH($_POST['id']);
            $userID = $_POST['id'];
            $memberUsername = getNameFromId($_POST['id'])['username'];

            foreach ($transactions as $row) {

                $Unixdate = strtotime($row['time']);
                $date = date('F j, Y, g:i a', $Unixdate);

                if ($row['sender_ID'] == $userID) {
                        $balanceText = "$memberUsername's balance: $$row[senderBalance]";
                    if ($row['sendOrRequest'] == 'allowance') {
                        $text = ("$memberUsername received $$row[amount] as their allowance");
                    }
                    if ($row['sendOrRequest'] == 'send') {
                        $text = ("$memberUsername sent $$row[amount] to $row[recipient_username] for $row[note]");
                    }
                    if ($row['sendOrRequest'] == 'request') {
                        if ($row['fulfilled'] == 'sent') {
                            $text = ("$memberUsername sent $$row[amount] to $row[recipient_username] for $row[note] upon their request");
                        }
                        if ($row['fulfilled'] == 'declined') {
                            $text = ("$memberUsername declined a $$row[amount] request from $row[recipient_username] for $row[note]");
                        }
                        if ($row['fulfilled'] == 'pending') {
                            $text = ("$memberUsername has a $$row[amount] pending request from $row[recipient_username] for $row[note]");
                        }
                        if ($row['fulfilled'] == 'taken') {
                            $text = ("$row[recipient_username] took $$row[amount] from $memberUsername for $row[note]");
                        }
                    }
                }
                if ($row['recipient_ID'] == $userID) {
                    $balanceText = "$memberUsername's balance: $$row[receiverBalance]";
                    if ($row['sendOrRequest'] == 'send') {
                        $text = ("$row[sender_username] sent $$row[amount] to $memberUsername for $row[note]");
                    }
                    if ($row['sendOrRequest'] == 'request') {
                        if ($row['fulfilled'] == 'sent') {
                            $text = ("$row[sender_username] sent $$row[amount] to $memberUsername for $row[note] upon their request");
                        }
                        if ($row['fulfilled'] == 'declined') {
                            $text = ("$row[sender_username] declined $memberUsername's $$row[amount] request for $row[note]");
                        }
                        if ($row['fulfilled'] == 'pending') {
                            $text = ("$memberUsername's $$row[amount] request to $row[sender_username] for $row[note] is pending");
                        }
                        if ($row['fulfilled'] == 'taken') {
                            $text = ("$memberUsername took $$row[amount] from $row[sender_username] for $row[note]");
                        }
                    }
                }
                if ($text) {
                    print("<div id='requestAlerts'><div class='alert'>$text <div class='exDetails'><div class='transactionBalance'>$balanceText</div> <div class='transactionDate'>$date</div></div></div></div>");
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