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

    <?php 
            include_once 'db.php';
            include_once 'sessionStart.php';

            $sql = "SELECT family, username FROM people WHERE ID=?";
            $stmt = $db->prepare($sql);
            
            $stmt->bind_param("i", $id);
            $id = $_SESSION['id'];

            if (!$stmt->execute()) {
                print("execute error: ".$db->error);
            }
            $result = $stmt->get_result();
            $row = $result->fetch_assoc(); //row = totalCash array
            $family = $row['family'];  
            $username = $row['username'];

        ?>

    <div class="pageSpanBox"> 
        <div id="profilePageUsername" class="Dtext">
            <?php print_r("Logged in as "."$username");
            print_r(" "."$family"); ?>
        </div>
        <div id="familyMemberList">
            <div class="Etext"> Your Family: </div>
            <?php
            
            $sql = "SELECT familyCode FROM people WHERE ID = ?";
            $stmt = $db->prepare($sql);
            
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
            
            $stmt->bind_param("s", $familyCode);
            $id = $_SESSION['id'];
            $familyCode = $codeRow['familyCode'];

            if (!$stmt->execute()) {
                print("execute error: ".$db->error);
            }

            print_r("");
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $username = $row['username'];
                    $id = $row['ID'];
                    print_r("<div class='Etext'>-$username</div>");
                }
            ?>
        </div>
        <?php 
            include_once "parentCheck.php";
            if($parent == 1) {
                print_r("
                <a href='familyEditPage.php'>
                <button id='familyEditButton'>Edit</button>
                </a>
                ");
            }
        ?>
        <a href="logOut.php" id="profilePageLogOut">Log Out</a>
    </div>

    <script src="moneyApp.js"></script>
</body>
</html>