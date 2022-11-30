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

        <img src='images/filterIcon.png' id='filterIcon' class='closed'>
        <div id='filtersContainer' class='hidden'>
            <div class='Etext' id='filtersTitle'>Filters</div>
            <div id='filtersArea'>
                <form action='memberTHPage.php' method='post'>
                    <label class="container">Send
                        <input type="radio" name='transactionType' value="Send">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container">Request
                        <input type="radio" name='transactionType' value="Request">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container">Allowance
                        <input type="radio" name='transactionType' value="Allowance">
                        <span class="checkmark"></span>
                    </label>

                    <button name='id' value="<?php print_r($_POST['id']); ?>" id='filterSubmit'>Filter</button>
                </form>
            </div>
        </div>

        <div id="requestAlerts">
            <?php
            include_once 'getMemberTH.php';
            include_once 'parentCheck.php';
            include_once 'db_people.php';

            if (!isset($_POST['transactionType'])) {
                $transactions = getTH($_POST['id'],'no', ' ');
            } else {
                $transactions = getTH($_POST['id'],'yes', $_POST['transactionType']);
            }

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