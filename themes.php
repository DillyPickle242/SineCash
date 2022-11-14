<style>
    <?php
    include_once 'db.php';
    include_once 'sessionStart.php';
    $sql = "SELECT backgroundImg FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $id = $_SESSION['id'];
    $stmt->execute();
    $backgroundImg = $stmt->get_result()->fetch_assoc()['backgroundImg'];

    $sql = "SELECT defaultTheme FROM people WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $id = $_SESSION['id'];
    $stmt->execute();
    $defaultTheme = $stmt->get_result()->fetch_assoc()['defaultTheme'];

    if ($defaultTheme == 1) {
        $pageColor = 'rgb(57, 57, 57);';
        $backgroundColor = 'rgb(245, 245, 245)';
        $color = 'black';
        $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
        $font = "'Times New Roman', Times, serif";
        $size = '80px';
        print_r("
    html{
    background-color: $pageColor;
    }
    .hsButton {
        position: relative;
        text-align: center;
        height: 200px;
        width: 45%;
        margin: 2%;
        border-radius: 80px;
        border-width: 0px;

        background-color: $backgroundColor;
        color: $color;
        font-size: $size;
        font-family: $font;
        box-shadow: $shadow;
}
");
    } else {
        $theme = $backgroundImg;
        // hexagons
        // cpu
        // flower
        // floatShapes
        // moneySign
        // crystalHill
        // floweryField
        // rainy
        // doggieTrain
        // forestLake
        // synthwaveCar
        // starSky

        if ($theme == 'hexagons') {
            $pageColor = 'rgb(57, 57, 57);';
            $backgroundColor = 'rgb(245, 245, 245)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'cpu') {
            $pageColor = 'rgb(89, 103, 128)';
            $backgroundColor = 'rgb(170, 191, 225)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'flower') {
            $pageColor = 'rgb(43, 43, 43)';
            $backgroundColor = 'rgb(245, 245, 245)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'floatShapes') {
            $pageColor = 'rgb(10, 10, 10)';
            $backgroundColor = 'rgb(245, 245, 245)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(50, 50, 50, 0.472),
        -8px -8px 20px rgba(50, 50, 50, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'moneySign') {
            $pageColor = 'rgb(27, 48, 25)';
            $backgroundColor = 'rgb(213, 234, 173)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(50, 50, 50, 0.472),
        -8px -8px 20px rgba(50, 50, 50, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'crystalHill') {
            $pageColor = 'rgb(8, 14, 34)';
            $backgroundColor = 'rgb(146, 176, 1885)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(50, 50, 50, 0.472),
        -8px -8px 20px rgba(50, 50, 50, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'floweryField') {
            $pageColor = 'rgb(104,140,167)';
            $backgroundColor = 'rgb(245, 245, 245)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.172),
            -8px -8px 20px rgba(28, 28, 28, 0.188),
            inset -20px -20px 40px rgba(0, 0, 0, 0.262),
            inset  20px 20px 40px rgba(0, 0, 0, 0.249)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'rainy') {
            $pageColor = 'rgb(60, 95, 75)';
            $backgroundColor = 'rgb(174, 207, 188)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'doggieTrain') {
            $pageColor = 'rgb(80, 59, 84)';
            $backgroundColor = 'rgb(196, 196, 232)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'forestLake') {
            $pageColor = 'rgb(21, 55, 45)';
            $backgroundColor = 'rgb(216, 212, 196 )';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'synthwaveCar') {
            $pageColor = 'rgb(60, 42, 62)';
            $backgroundColor = 'rgb(234, 194, 235)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }
        if ($theme == 'starSky') {
            $pageColor = 'rgb(16, 25, 29)';
            $backgroundColor = 'rgb(201, 184, 162)';
            $color = 'black';
            $shadow = '-8px -8px 20px rgba(28, 28, 28, 0.472),
        -8px -8px 20px rgba(28, 28, 28, 0.488),
        inset -20px -20px 40px rgba(0, 0, 0, 0.362),
        inset  20px 20px 40px rgba(0, 0, 0, 0.349)';
            $font = "'Times New Roman', Times, serif";
            $size = '80px';
        }


        print_r("
html{ background-color: $pageColor; }

.hsButton {
    position: relative;
    text-align: center;
    height: 200px;
    width: 45%;
    margin: 2%;
    border-radius: 80px;
    border-width: 0px;

    background-Image: $backgroundImg;
    background-color: $backgroundColor;
    color: $color;
    font-size: $size;
    font-family: $font;
    box-shadow: $shadow;
}
");
    }
    ?>
</style>