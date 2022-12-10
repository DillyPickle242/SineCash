<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <div class="pageSpanBox">
        <?php
        include_once 'db.php';
        include_once 'sessionStart.php';
        include_once 'db_people.php';
        include_once 'db_allowance.php';

        $username = getNameFromId($_POST['id'])['username'];
        $totalCash = getTotalCashFromId($_POST['id'])['totalCash'];
        
        print_r("<form action='deleteMember.php' method='post'><button name='id' value='$_POST[id]' id='removeFromFamily'>Remove From Family</button></form>");

        if (parentFromId($_POST['id'])['parent'] == 0) {
            print_r("<div class='Etext'> $username has $$totalCash in their account </div>");
        } else {
            print_r("<div class='Etext'>$username's account</div>");
        }
        print_r("<form action='memberTHPage.php' method='post'> <button name='id' value='$_POST[id]' class='Etext' id='memberTHbutton'> Transaction History </div> </form>");

        ?>
    </div>

    
        <?php
if (parentFromId($_POST['id'])['parent'] == 0) {
    print_r("<div class='pageSpanBox'>");
        $allowanceInfo = getAllowanceInfo($_POST['id']);
        $allowanceAmount = $allowanceInfo['amount'];
        $allowanceFrequency = $allowanceInfo['frequency'];
        $allowanceTime = $allowanceInfo['nextTimeGiven'];

        $d = getdate($allowanceTime);
        $dbDOW = $d['wday'];

        //selecting the currently selected day/frequency
        {
            if ($dbDOW == 0) {
                $DOW1 = 'selected';
                $DOW2 = ' ';
                $DOW3 = ' ';
                $DOW4 = ' ';
                $DOW5 = ' ';
                $DOW6 = ' ';
                $DOW7 = ' ';
            }
            if ($dbDOW == 1) {
                $DOW1 = ' ';
                $DOW2 = 'selected';
                $DOW3 = ' ';
                $DOW4 = ' ';
                $DOW5 = ' ';
                $DOW6 = ' ';
                $DOW7 = ' ';
            }
            if ($dbDOW == 2) {
                $DOW1 = ' ';
                $DOW2 = ' ';
                $DOW3 = 'selected';
                $DOW4 = ' ';
                $DOW5 = ' ';
                $DOW6 = ' ';
                $DOW7 = ' ';
            }
            if ($dbDOW == 3) {
                $DOW1 = ' ';
                $DOW2 = ' ';
                $DOW3 = ' ';
                $DOW4 = 'selected';
                $DOW5 = ' ';
                $DOW6 = ' ';
                $DOW7 = ' ';
            }
            if ($dbDOW == 4) {
                $DOW1 = ' ';
                $DOW2 = ' ';
                $DOW3 = ' ';
                $DOW4 = ' ';
                $DOW5 = 'selected';
                $DOW6 = ' ';
                $DOW7 = ' ';
            }
            if ($dbDOW == 5) {
                $DOW1 = ' ';
                $DOW2 = ' ';
                $DOW3 = ' ';
                $DOW4 = ' ';
                $DOW5 = ' ';
                $DOW6 = 'selected';
                $DOW7 = ' ';
            }
            if ($dbDOW == 6) {
                $DOW1 = ' ';
                $DOW2 = ' ';
                $DOW3 = ' ';
                $DOW4 = ' ';
                $DOW5 = ' ';
                $DOW6 = ' ';
                $DOW7 = 'selected';
            }
        } {
            if ($allowanceFrequency == 0) {
                $frequency0 = 'selected';
                $frequency7 = ' ';
                $frequency14 = ' ';
            }
            if ($allowanceFrequency == 7) {
                $frequency0 = ' ';
                $frequency7 = 'selected';
                $frequency14 = ' ';
            }
            if ($allowanceFrequency == 14) {
                $frequency0 = ' ';
                $frequency7 = ' ';
                $frequency14 = 'selected';
            }
        }

        
            print_r("<div class='Etext'> $username's allowance Settings: </div>");
            print_r("
        <form action='allowanceEditing.php' method='post'>
            <div>
                <div class='Ftext'>Allowance Amount</div>
                <input class='memberEdit' name='amount' placeholder='$allowanceAmount'>
            </div>

            <div>
                <div class='Ftext'>Allowance Frequency</div>
                <select name='frequency' class='memberEdit'>
                    <option $frequency0 value='0' > Never </option>
                    <option $frequency7 value='7' >Once a week</option>
                    <option $frequency14 value='14' >Once every two weeks</option>
                </select>
            </div>
            <div>
                <div class='Ftext'>Allowance Date of Week</div>
                <select name='DOW' class='memberEdit'>
                    <option value='Sunday' $DOW1>Sunday</option>
                    <option value='Monday' $DOW2>Monday</option>
                    <option value='Tuesday' $DOW3>Tuesday</option>
                    <option value='Wednesday' $DOW4>Wednesday</option>
                    <option value='Thursday' $DOW5>Thursday</option>
                    <option value='Friday' $DOW6>Friday</option>
                    <option value='Saturday' $DOW7>Saturday</option>
                </select>
            </div>
            <button name='id' value='$_POST[id]' class='memberEdit'>Submit Changes</button>
        </form>
        </div>
        ");
        }
        ?>
</body>

</html>