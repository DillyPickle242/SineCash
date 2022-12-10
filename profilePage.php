<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>

    <?php
    include_once 'db.php';
    include_once 'sessionStart.php';
    include_once "parentCheck.php";
    include_once "db_people.php";

    $sql = "SELECT family, username FROM people WHERE ID=?";
    $stmt = $db->prepare($sql);

    $stmt->bind_param("i", $id);
    $id = $_SESSION['id'];

    if (!$stmt->execute()) {
        print("execute error: " . $db->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc(); //row = totalCash array
    $family = $row['family'];
    $username = $row['username'];

    ?>

    <div class="pageSpanBox">
        <div id="profilePageUsername" class="Dtext">
            <?php print_r("Logged in as " . "$username");
            print_r(" " . "$family"); ?>
        </div>
        <?php
        if ($parent == 1) {
            print_r("
        <div id='familyMemberList'>
        <div class='Etext'> Your Family: </div>
        <form action='memberEditPage.php' method='post'>
        ");

            $sql = "SELECT familyCode FROM people WHERE ID = ?";
            $stmt = $db->prepare($sql);

            $stmt->bind_param("s", $id);
            $id = $_SESSION['id'];
            //$stmt->bind_param("s", $id);
            //$id = $_SESSION['id'];
            if (!$stmt->execute()) {
                print("execute error: " . $db->error);
            }
            $result = $stmt->get_result();
            $codeRow = $result->fetch_assoc();
            $familyCode = $codeRow['familyCode'];


            $sql = "SELECT username, ID FROM people WHERE familyCode = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $familyCode);
            $familyCode = $codeRow['familyCode'];
            if (!$stmt->execute()) {
                print("execute error: " . $db->error);
            }

            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                $id = $row['ID'];
                print_r("<button name='id' value='$id' class='Etext'>-$username</button>");
            }


            if (familyLocked($familyCode)['familyLocked'] == 1){
                $locked = 'checked';
            } else {
                $locked = ' ';
            }

            print_r("
            </form>
        </div>
        <form action='lockingFamily.php' method='post'>
            <div id='lockFamilyTitle'>Lock family</div>
            <input $locked name='lockedCheck' value='yes' type='checkbox' id='lockFamilyCheck'>
            <div id='lockFamilyDescription'>This will disable people from joining your family</div>
            <button class='Ftext'>Submit changes</button>
        </form>
        ");
        }
        ?>
        <a href="logOut.php" id="profilePageLogOut">Log Out</a>
    </div>

    <script src="moneyApp.js"></script>
</body>

</html>