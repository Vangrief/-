<!DOCTYPE html>

<?php
session_start();

// Taking all values from the form data(input)
if (isset($_REQUEST['benutzername']) && isset($_REQUEST['pwssd'])) {
    $benutzername =  $_REQUEST['benutzername'];
    $password = $_REQUEST['pwssd'];
    if (true == true) {   
        $dbdir = './db';
        /* Datenbankdatei ausserhalb htdocs öffnen bzw. erzeugen */
        $db = new SQLite3("$dbdir/sq3.db");

        $statement = $db->prepare('SELECT * FROM personen WHERE benutzername = :id;');
        $statement->bindValue(':id', $benutzername);
        $result = $statement->execute();
        $result = $result->fetchArray();
        if (!empty($result)) {
            /*Benuter exists*/
            if (password_verify($_REQUEST['pwssd'], $result["pwssd"])) {
                $_SESSION['currentBenutzer'] = $benutzername;
            } else {
                unset($_SESSION['currentBenutzer']);
                $verkackt = "Falsches Passwort oder falscher Name";
            }
        } else {
            $verkackt = "Falsches Passwort oder falscher Name";
        }
    } else {
        $verkackt = true;
    }
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_SESSION['currentBenutzer'])) {
    echo $_SESSION['currentBenutzer'];
} else {
    unset($_SESSION['currentBenutzer']);
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
            <h1>Login</h1>

            <form action="login.php" method="post">
                <label for="benutzername">Benutzername</label>
                <input type="text" id="benutzername" name="benutzername"><br><br>
                <label for="lname">Passwort</label>
                <input type="password" id="pwssd" name="pwssd"><br><br>
                <input type="submit" value="Submit">
            </form>

            <?php
            if (isset($verkackt)) {
                echo "<p style='color: red;'>".$verkackt."<p>";
            }
            ?>

            <p>
                Sie haben noch kein Konto?
                <a href="register.php">Registrieren</a>
            </p>


        </main>
        <footer>
            <hr>
            <p><a href="mailto:jpm@nobody.xyz?Subject=Quietschenten">Quietschenten-Shop © 2021</a></p>
        </footer>
    </div>
</body>

</html>