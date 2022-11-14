<html>
<header>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
    <div id="topBar">
        <div id="title" class="Atext"> SineCash </div>
    </div>
</header>
<body>
    <?php include_once 'sessionStart.php'; ?>
    <div class="Ctext">Are you an adult or child?</div>
    <a href="familySetup.php">
        <button class="confirmationButton">Adult</button>
    </a>
    <a href="familyJoin.php">
        <button class="confirmationButton">Child</button>
    </a>

</body>
</html>