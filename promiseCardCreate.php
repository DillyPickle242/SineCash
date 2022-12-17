<html>

<head>
    <link rel="stylesheet" href="moneyApp.css?<?php echo time(); ?>">

    <?php
    include_once 'themes.php';
    include_once 'sessionStart.php';
    include_once 'db.php';
    include_once 'db_allowance.php';
    include_once 'parentCheck.php';

    giveAllowances();

    $familyCode = getFamilyCode();
    if (!$familyCode) {
        header("location: loginPage.php");
    }


    ?>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <form action='creatingPromiseCard.php' method='post'>
        <div>
            <div class="Btext">
                Please select recipient
            </div>
            <select name="cardPersonSelect" id="cardPersonSelect" class="formBox">
                <?php include_once 'memberDropDownMenu.php';
                include_once 'sessionStart.php';
                makeDropDown($_SESSION['id']);
                ?>
            </select>
        </div>
        <div>
            <div class="Btext">
                What is the title?
            </div>
            <input name="cardTitle" id="cardTitle" class="formBox">
        </div>
        <div>
            <div class="Btext">
                Provide a short description of what this promise card is for
            </div>
            <textarea name="cardDescription" id="cardDescription" class="formBox"></textarea>
        </div>
        <div>
            <div class="Btext">
                How many cards would you like to send?
            </div>
            <input name="cardCount" id="cardCount" class="formBox" type="number" step="1" min=1 max=10>
        </div>
        <button id="cardDoneButton" class="formbox">Done</button>
    </form>
</body>

</html>