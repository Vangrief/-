<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
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

            <form action="/action_page.php">
                <label for="fname">Benutzername</label>
                <input type="text" id="fname" name="fname"><br><br>
                <label for="lname">Passwort</label>
                <input type="password" id="pwssd" name="pwssd"><br>
                <label for="lname">Passwort</label>
                <input type="password" id="pwssd" name="pwssd"><br><br>
                <input type="submit" value="Submit">
            </form>

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