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
    </header>

    <form id="sendForm" action="sending.php" method="post">
        <div>
            <div class="Btext">
                Please select recipient
            </div>
            <select name="sendPersonSelect" id="sendPersonSelect" class="formBox">
                <option value='?null'>...</option>
                <?php 
                include_once "db.php";
                include_once 'sessionStart.php';
            //gett family code from id
                $sql = "SELECT familyCode FROM people WHERE ID = ?";
                $stmt = $db->prepare($sql);
                if (!$stmt){
                    print("error: ".$db->error);
                }
                $stmt->bind_param("s", $id);
                $id = $_SESSION['id'];
                //$stmt->bind_param("s", $id);
                //$id = $_SESSION['id'];
                if (!$stmt->execute()) {
                    print("execute error: ".$db->error);
                }

                $result = $stmt->get_result();
                $codeRow = $result->fetch_assoc();
                $familyCode = $codeRow['familyCode'];


                $sql = "SELECT username, ID FROM people WHERE familyCode = ?";
                $stmt = $db->prepare($sql);
                if (!$stmt){
                    print("error: ".$db->error);
                }
                $stmt->bind_param("s", $familyCode);
                $id = $_SESSION['id'];
                $familyCode = $codeRow['familyCode'];

                if (!$stmt->execute()) {
                    print("execute error: ".$db->error);
                }

                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $username = $row['username'];
                    $id = $row['ID'];

                    print_r("<option value='".$id."'>".$username."</option> ");
                }
                
                ?>
            </select>
        </div>
        <div>
            <div class="Btext">
                How much would you like to send?
            </div>
            <input name="sendCashAmount" id="sendCashAmount" class="formBox" type="number" step="0.01" min=0.01 max=1000000>
        </div>
        <div>
            <div class="Btext">
                Note: for...
            </div>
            <input name="sendNote" id="sendNote" class="formBox">
        </div>
        <button id="sendDoneButton" class="formbox">Done</button>

        <div class="hidden" id="confirmation">
            <div class="dimmedScreen"></div>
            <div id="confirmationBox">
                <div id=sendConfirm class="btext"></div>
                <button id="sendConfirmYes" data-submit="1" class="confirmationButton">Yes</button>
                <button id="sendConfirmNo" class="confirmationButton">No</button>
            </div>
        </div>
    </form>

    

    <script src="moneyApp.js"></script>
</body>

</html>