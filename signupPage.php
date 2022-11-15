<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>

</head>
<body>
    <header>
        <div id="topBar">
            <div id="title" class="Atext"> SineCash </div>
            <a href="loginPage.php" class="topMenuTextSwitcher">Login</a>
        </div>
    </header>

    
    <form id="signupForm" action="signingUp.php" method="post">
        <div class="Ctext">Sign Up</div>
        <div>
            <div class="Btext">
            please enter your first name
            </div>
            <input name="usernameCreate" id="usernameCreate" class="formBox">
        </div>
        <div>
            <div class="Btext">
            please enter your email
            </div>
            <input type="email" name="emailCreate" id="emailCreate" class="formBox">
        </div>
        <div>
            <div class="Btext">
            please create a password
            </div>
            <input type="password" name="passwordCreate" id="passwordCreate" class="formBox">
        </div>
        <div>
            <div class="Btext">
            please re-enter you password
            </div>
            <input type="password" name="passwordCreateCheck" id="passwordCreateCheck" class="formBox">
        </div>
        <button id="signupDoneButton" class="formbox">create account</button>
    </form>
    
    <script src="moneyApp.js"></script>
</body>

</html>