<html>
<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
    <?php
    include_once 'db.php';
    include_once 'sessionStart.php';
    include_once "parentCheck.php";
    if($parent == 0) {
        print_r("you arent a parent");
        header("location: index.php");
    }
    ?>
</head>
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
<body>
    <div class="pageSpanBox">
        Children:
        <div>
        <?php 
            include_once 'db_people.php';
            $familyCode = getFamilyCode();
            $childrenResults = getChildInfo($familyCode);

        ?>
        <form action="updatingFamily.php" method="post">
        <table>
        <tr>
          <th>Name <div class='familyEditInformative'>Your child's username</div></th>
          <th>Balance <div class='familyEditInformative'>The total cash in this child's account</div></th>
          <th>Allow. Amount <div class='familyEditInformative'>The amount your child will receive in their allowance</div></th>
          <th>Allow. Frequency <div class='familyEditInformative'>How often your child will recieve their allowance</div></th>
          <th>Allow. DOW <div class='familyEditInformative'>The day of the week that your child will be receiving their allowance</div></th>
        </tr>
        <?php 
        foreach ($childrenResults as $child) {
            $username = $child['username'];
            $id = $child['ID'];
            $totalCash = $child['totalCash'];
            include_once 'db_allowance.php';
            $allowanceInfo = getAllowanceInfo($id);
            $allowanceAmount = $allowanceInfo['amount'];
            $allowanceFrequency = $allowanceInfo['frequency'];
            $allowanceTime = $allowanceInfo['nextTimeGiven'];
            
            
            $d=getdate($allowanceTime);
            $dbDOW = $d['wday'];
            
            {
                if($dbDOW == 0) {
                    $DOW1 = 'selected';
                    $DOW2 = ' ';
                    $DOW3 = ' ';
                    $DOW4 = ' ';
                    $DOW5 = ' ';
                    $DOW6 = ' ';
                    $DOW7 = ' ';
                }
                if($dbDOW == 1) {
                    $DOW1 = '';
                    $DOW2 = 'selected';
                    $DOW3 = ' ';
                    $DOW4 = ' ';
                    $DOW5 = ' ';
                    $DOW6 = ' ';
                    $DOW7 = ' ';
                }
                if($dbDOW == 2) {
                    $DOW1 = ' ';
                    $DOW2 = ' ';
                    $DOW3 = 'selected';
                    $DOW4 = ' ';
                    $DOW5 = ' ';
                    $DOW6 = ' ';
                    $DOW7 = ' ';
                }
                if($dbDOW == 3) {
                    $DOW1 = ' ';
                    $DOW2 = ' ';
                    $DOW3 = ' ';
                    $DOW4 = 'selected';
                    $DOW5 = ' ';
                    $DOW6 = ' ';
                    $DOW7 = ' ';
                }
                if($dbDOW == 4) {
                    $DOW1 = ' ';
                    $DOW2 = ' ';
                    $DOW3 = ' ';
                    $DOW4 = ' ';
                    $DOW5 = 'selected';
                    $DOW6 = ' ';
                    $DOW7 = ' ';
                }
                if($dbDOW == 5) {
                    $DOW1 = ' ';
                    $DOW2 = ' ';
                    $DOW3 = ' ';
                    $DOW4 = ' ';
                    $DOW5 = ' ';
                    $DOW6 = 'selected';
                    $DOW7 = ' ';
                }
                if($dbDOW == 6) {
                    $DOW1 = ' ';
                    $DOW2 = ' ';
                    $DOW3 = ' ';
                    $DOW4 = ' ';
                    $DOW5 = ' ';
                    $DOW6 = ' ';
                    $DOW7 = 'selected';
                }
            }
            {
                if($allowanceFrequency == 0) {
                    $frequency0 = 'selected';
                    $frequency7 = 'selected';
                    $frequency14 = ' ';
                }
                if($allowanceFrequency == 7) {
                    $frequency0 = ' ';
                    $frequency7 = 'selected';
                    $frequency14 = ' ';
                }
                if($allowanceFrequency == 14) {
                    $frequency0 = ' ';
                    $frequency7 = '';
                    $frequency14 = 'selected';
                }
            }


            print_r("
                <tr>
                <td>$username</td>
                <td>$totalCash</td>
                <td><input name='data[$id][allowanceAmount]' placeholder='$allowanceAmount'></td>
                <td>
                    <select name='data[$id][allowanceFrequency]' id='frequencyDaySelect' class='familyEditDOW'>
                        <option $frequency0 value='0' > Never </option>
                        <option $frequency7 value='7' >Once a week</option>
                        <option $frequency14 value='14' >Once every two weeks</option>
                    </select>
                </td>
                <td>
                    <select name='data[$id][datePick]' id='weekDaySelect' class='familyEditDOW'>
                        <option $DOW1>Sunday</option>
                        <option $DOW2>Monday</option>
                        <option $DOW3>Tuesday</option>
                        <option $DOW4>Wednesday</option>
                        <option $DOW5>Thursday</option>
                        <option $DOW6>Friday</option>
                        <option $DOW7>Saturday</option>
                    </select>
                </td>

                </tr>
            ");
        }
        ?>
        </table>
            <button id="familyEditDoneButton">Submit Changes</button>
        </form>

        

        </div>
    </div>
    <div class="pageSpanBox">
        Parents:
        <div>
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


            $sql = "SELECT username, ID FROM people WHERE familyCode = ? AND parent = 1";
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
    </div>
    
    
</body>
</html>