<html>

<head>
    <link rel="stylesheet" href="moneyApp.css"> <?php include 'themes.php'; ?>
</head>

<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <div class='pageSpanBox'>
        <?php
        include_once 'db_people.php';
        $username = getNameFromId($_POST['id'])['username'];

        print_r("
        <div class='Etext'>Are you SURE you want to delete '$username' from your family? This action CANNOT be undone. All transaction history including $username will also be deleted.</div>
        <form action='deletingMember.php' method='post'>
        <button name='deletedMember' value='$_POST[id]' class='Etext' id='memberDeleteButton'>Yes, Delete $username from my family</button>
        </form>
        ")
        
        ?>
    </div>
</body>

</html>