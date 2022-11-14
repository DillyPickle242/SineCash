<html>
<header>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
    <div id="topBar">
        <div id="title" class="Atext"> SineCash </div>
    </div>
</header>
<body>

    <form id="familyJoin" action="joiningFamily.php" method="post">
        <div class="Ctext">Join a Family</div>
        <div>
            <div class="Btext">
            Please enter your family code (your family organizer can give it to you)
            </div>
            <input name="familyCode" id="familyCode" class="formBox" pattern="[A-Z]{4}">
        </div>
        <button id="familySetupButton" class="formButton">Join Family</button>
    </form>




</body>
</html>