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
    <div class='pageSpanBox'>
        <?php
        include 'db_people.php';
        $username = getNameFromId($_POST['id'])['username'];

        print_r("
        <div class='Etext'>Are you SURE you want to delete '$username' from your family? This action CANNOT be undone.</div>
        <button> </button>
        ")
        
        ?>
    </div>
</body>

</html>