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
    <div class="btext">
        Home Page Background:
        <form action='settingsSubmit.php' method='post'>
            <button class='backImgSelectButton' value="hexagons" name="backgroundImg">
                <img class='backImgSelect'src='images/-hexagons.gif'> </button>

            <button class='backImgSelectButton' value="cpu" name="backgroundImg">
                <img class='backImgSelect' src='images/-cpu.gif'></button>

            <button class='backImgSelectButton' value="flower" name="backgroundImg">
                <img class='backImgSelect' src='images/-flower.gif'></button>

            <button class='backImgSelectButton' value="floatShapes" name="backgroundImg">
                <img class='backImgSelect' src='images/-floatShapes.gif'></button>

            <button class='backImgSelectButton' value="moneySign" name="backgroundImg">
                <img class='backImgSelect' src='images/-moneySign.gif'></button>

            <button class='backImgSelectButton' value="crystalHill" name="backgroundImg">
                <img class='backImgSelect' src='images/-crystalHill.gif'></button>

            <button class='backImgSelectButton' value="floweryField" name="backgroundImg">
                <img class='backImgSelect' src='images/-floweryField.gif'></button>

            <button class='backImgSelectButton' value="rainy" name="backgroundImg">
                <img class='backImgSelect' src='images/-rainy.gif'></button>

            <button class='backImgSelectButton' value="doggieTrain" name="backgroundImg">
                <img class='backImgSelect' src='images/-doggieTrain.gif'></button>

            <button class='backImgSelectButton' value="forestLake" name="backgroundImg">
                <img class='backImgSelect' src='images/-forestLake.gif'></button>

            <button class='backImgSelectButton' value="synthwaveCar" name="backgroundImg">
                <img class='backImgSelect' src='images/-synthwaveCar.gif'></button>

            <button class='backImgSelectButton' value="starSky" name="backgroundImg">
                <img class='backImgSelect' src='images/-starSky.gif'></button>

            <input id='defaultTheme'type="checkbox" value="1" name="defaultTheme"> Default Theme</input>
        </form>


    </div>
    <script src="moneyApp.js"></script>
</body>
</html>