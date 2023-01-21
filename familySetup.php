<html>
<header>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; 
?>
    
</header>

<body>
    <header>
        <div id="topBar">
            <div id="title" class="Atext"> SineCash </div>
        </div>
    </header>

    
    <form id="familySetup" action="settingUpFamily.php" method="post">
        <div class="Ctext">Family Setup</div>
        <div>
            <div class="Btext">
            Please enter a family name
            </div>
            <input name="familyName" id="familyName" class="formBox" pattern="[A-Za-z]{2,30}">
        </div>
        <button id="familySetupButton" class="formButton">Create Family</button>
    </form>


    <form id="familyJoin" action="joiningFamilyParent.php" method="post">
        <div class="Ctext">Join a Family</div>
        <div>
            <div class="Btext">
            OR enter your family code
            </div>
            <input name="familyCode" id="familyCode" class="formBox" pattern="[A-Z]{4}">
        </div>
        <button id="familySetupButton" class="formButton">Join Family</button>
    </form>
    



    <script src="moneyApp.js"></script>
</body>

</html>