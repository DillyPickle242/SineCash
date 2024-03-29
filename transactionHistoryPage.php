<html>

<head>
    <link rel="stylesheet" href="moneyApp.css?<?php echo time(); ?>"> <?php include 'themes.php'; ?>

</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <img src='images/filterIcon.png' id='filterIcon' class='closed'>
    <div id='filtersContainer' class='hidden'>
        <div class='Etext' id='filtersTitle'>Filters</div>
        <div id='filtersArea'>
            <form action='transactionHistoryPage.php' method='post'>
                <div>
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
                </div>
                <div>
                    <div class="Btext">
                        Search by person
                    </div>
                    <select name="searchID" id="searchID" class="formBox">
                        <?php include_once 'memberDropDownMenu.php'; 
                        include_once 'sessionStart.php';
                        makeDropDown($_SESSION['id']);
                        ?>
                    </select>
                </div>
                <button id='filterSubmit'>Filter</button>
            </form>
        </div>
    </div>

    <div id="requestAlerts">
        <?php
        include_once 'getTransactionHistory.php';
        include_once 'parentCheck.php';

        if (!$_POST) {
            $transactions = getTH('no', 'null', 'null');
        } else {
            if (!isset($_POST['searchID']) || $_POST['searchID'] == '?null') {
                $searchID = $_SESSION['id'];
            } else {
                $searchID = $_POST['searchID'];
            }
            if (!isset($_POST['transactionType'])) {
                $transactionType = 'null';
            } else {
                $transactionType = $_POST['transactionType'];
            }
            $transactions = getTH('yes', $transactionType, $searchID);
        }

        foreach ($transactions as $row) {

            $userID = $_SESSION['id'];

            $Unixdate = strtotime($row['time']);
            $date = date('F j, Y, g:i a', $Unixdate);

            if ($row['sender_ID'] == $userID) {
                if ($parent == 0) {
                    $balanceText = "Balance: $$row[senderBalance]";
                } else {
                    $balanceText = ' ';
                }

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
                if ($parent == 0) {
                    $balanceText = "Balance: $$row[receiverBalance]";
                } else {
                    $balanceText = ' ';
                }
                if ($row['sendOrRequest'] == 'allowance') {
                    $text = ("You received $$row[amount] as your allowance");
                }
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
                        $text = ("You took $$row[amount] from $row[sender_username] for $row[note]");
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

    <script src="moneyApp.js"></script>
</body>

</html>