<html>

<head>
    <link rel="stylesheet" href="moneyApp.css?<?php echo time(); ?>">

    <?php
    include_once 'themes.php';
    include_once 'sessionStart.php';
    include_once 'db.php';
    include_once 'db_allowance.php';
    include_once 'parentCheck.php';
    include_once 'db_people.php';

    global $db;
    $sql = "SELECT sender, title, `description`, count, ID FROM promiseCards WHERE recipient = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $id = $_SESSION['id'];
    $stmt->execute();
    $result = $stmt->get_result();
    $ret = array();
    while ($row = $result->fetch_assoc()) {
        $ret[] = $row;
    }
    ?>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <div id='cardContainer'>
        <?php
        foreach ($ret as $row) {
            $sender = $row['sender'];
            $senderUsername = getNameFromId($sender)['username'];
            $title = $row['title'];
            $description = $row['description'];
            $count = $row['count'];
            $cardId = $row['ID'];
            if($countId > 1){
                print_r("
            <div class='promiseCard'>
            <div class='promiseCardText'>
                <div class='promiseCardTitle'>$title</div>
                <div class='promiseCardDesc'>$description</div>
                <div class='promiseCardFrom'>From: $senderUsername</div>
                <div class='promiseCardCount'>Count: $count</div>
            </div>
            <div class='promiseCardBack hidden'>
                <div class='promiseCardTitle'>$title</div>
                <form action='usePromiseCard.php' method='post'>
                <button name='cardId' value='$cardId' class='promiseCardButton'>Use this card</button>
                </form>
                <div class='promiseCardFrom'>From: $senderUsername</div>
                <div class='promiseCardCount'>Count: $count</div>
            </div>
            <img class='promiseCardBackground' src='images/promiseCard.gif'>
            <img class='promiseCardBackground promiseCardBackgroundBack hidden' src='images/silverPromiseCard.gif'>
            </div>
            ");
            }
        }
        ?>
    </div>
    <script src="moneyApp.js?<?php echo time(); ?>"></script>
</body>