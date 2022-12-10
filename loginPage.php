<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>

</head>
<body>
    <header>
        <div id="topBar" >
            <div id="title" class="Atext"> SineCash </div>
            <a href="signupPage.php" class="topMenuTextSwitcher">Sign Up</a>
        </div>
        <div id='topBarSpacer'></div>
    </header>

    <form id="loginForm" method="post" action="loggingIn.php">
        <div class="Ctext">Login</div>
        <div>
            <div class="Btext">
            Please enter your first name
            </div>
            <input name="usernameLogin" id="usernameLogin" class="formBox">
        </div>
        <div>
            <div class="Btext">
            Please enter your password
            </div>
            <input type="password" name="passwordLogin" id="passwordLogin" class="formBox">
        </div>
        <button id="loginDoneButton" class="formbox">Login</button>
    </form>

    <script src="moneyApp.js"></script>
</body>

</html>