<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>

</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>

    <form id="sendForm" action="sending.php" method="post">
        <div>
            <div class="Btext">
                Please select recipient
            </div>
            <select name="sendPersonSelect" id="sendPersonSelect" class="formBox">
                <?php include_once 'memberDropDownMenu.php'; 
                include_once 'sessionStart.php';
                makeDropDown($_SESSION['id']);
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