<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_SESSION['currentBenutzer'])) {
    echo $_SESSION['currentBenutzer'];
}

// Taking all values from the form data(input)
if (isset($_POST['benutzername']) && isset($_POST['pwssd'])) {
    $benutzername =  $_POST['benutzername'];
    $password = $_POST['pwssd'];
    echo $password;
    if ($password == $_POST['pwssd2']) {
        //Datenbank
        $dbdir = './db';
        /* Datenbankdatei ausserhalb htdocs öffnen bzw. erzeugen */
        $db = new SQLite3("$dbdir/sq3.db");

        $statement = $db->prepare('SELECT * FROM personen WHERE benutzername = :id;');
        $statement->bindValue(':id', $benutzername);
        $result = $statement->execute();
        $result = $result->fetchArray();
        if (!empty($result)) {
            /*Benuter exists*/
            $verkackt = true;
        } else {
            $benutzerid = idate("B") . idate("s") . random_int(0, 1000000);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $_SESSION['currentBenutzer'] = $benutzername;
            $sqlstr = "INSERT INTO personen (benutzerId, benutzername, pwssd) VALUES ";
            $db->query($sqlstr . "('$benutzerid', '$benutzername', '$password')");
        }
    } else {
        $verkackt = true;
    }
} else {
    echo "geht nicht";
}
?>

<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Quietschentenshop" name="description">
    <meta content="Jean-Pierre Mouret" name="author">
    <title>Startseite</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Ubuntu:700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/custom.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Quietschenten-Shop</h1>
        </header>
        <nav>
            <ul>
                <li><a href="index.php"><b>Startseite</b></a></li>
                <li><a href="catalog.php">Katalog</a></li>
                <li><a href="cart.php"><i class="fa fa-shopping-cart" style="font-size:20px"></i> (<?php echo count($_SESSION['cart']); ?>)</a></li>
            </ul>
        </nav>
        <main>
            <h1>Registrieren</h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="benutzername">Benutzername</label>
                <input type="text" name="benutzername" id="benutzername"><br><br>
                <label for="lname">Passwort</label>
                <input type="password" id="pwssd" name="pwssd"><br>
                <label for="lname">Passwort</label>
                <input type="password" id="pwssd2" name="pwssd2"><br><br>
                <input type="submit" value="Submit">
            </form>

            <?php
            if (isset($verkackt)) {
                echo "<p style='color: red;'>Die Registrierung ist fehlgeschlagen<p>";
            }
            ?>

            <p>
                Sie haben schon ein Konto?
                <a href="login.php">Login</a>
            </p>
        </main>
        <footer>
            <hr>
            <p><a href="mailto:jpm@nobody.xyz?Subject=Quietschenten">Quietschenten-Shop © 2021</a></p>
        </footer>
    </div>
</body>

</html>