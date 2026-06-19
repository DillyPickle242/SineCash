<html>

<head>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>

    <form id="requestForm" action="requesting.php" method="post" class="requestFormContainer">
        <div class="requestSection">
            <div class="Btext">
                Who are you requesting from?
            </div>
            <div class="requestPersonItem requestSelectAllItem" id="requestSelectAll">
                <span>Select All</span>
            </div>
            <div id="requestPersonList" class="requestPersonList">
                <?php include_once 'memberDropDownMenu.php';
                include_once 'sessionStart.php';
                makeRequestCheckboxList($_SESSION['id']);
                ?>
            </div>
        </div>
        <div class="requestSection">
            <div class="Btext">
                How much would you like to request?
            </div>
            <input name="requestCashAmount" id="requestCashAmount" class="formBox" type="number" step="0.01" min=0.01 max=1000000>
            <div id="splitSummary" class="splitSummary">Choose people to request from and the amount will be split evenly.</div>
        </div>
        <div class="requestSection">
            <div class="Btext">
                Note: for...
            </div>
            <input name="requestNote" id="requestNote" class="formBox">
        </div>
        <button id="requestDoneButton" class="formbox">Done</button>

        <div class="hidden" id="confirmation">
            <div class="dimmedScreen"></div>
            <div id="confirmationBox">
                <div id=requestConfirm class="btext"></div>

                <button id="requestConfirmYes" data-submit="1" class="confirmationButton">Yes</button>
                <button id="requestConfirmNo" class="confirmationButton">No</button>
            </div>
        </div>
    </form>


    <script src="moneyApp.js"></script>
</body>

</html>