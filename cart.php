<!DOCTYPE html>

<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['empty'])) {
    // Empty the $_SESSION['cart'] array
    unset($_SESSION['cart']);
    header('location: ' . $_SERVER['PHP_SELF'] . '?' . SID);
    exit();
}
$items = [
    [
        "name" => "Quietschente rot",
        "count" => 0,
        "price" => 6.95,
    ],
    [
        "name" => "Quietschente blau",
        "count" => 0,
        "price" => 6.95,
    ],
    [
        "name" => "Quietschente gelb",
        "count" => 0,
        "price" => 6.95,
    ],
    [
        "name" => "Quietschente silber",
        "count" => 0,
        "price" => 8.95,
    ],
    [
        "name" => "Quietschente gold",
        "count" => 0,
        "price" => 11.95,
    ],
];

for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
    $itemIndex = $_SESSION["cart"][$i];
    $items[$itemIndex]["count"] += 1;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <meta content="Quietschentenshop" name="description">
        <meta content="Jean-Pierre Mouret" name="author">
        <title>Warenkorb</title>
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
                    <li><a href="index.php">Startseite</a></li>
                    <li><a href="catalog.php">Katalog</a></li>
                    <li><a href="cart.php"><i class="fa fa-shopping-cart" style="font-size:20px"></i> (<?php echo count($_SESSION['cart']); ?>)</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
            <main>
                <h1>Ihr Warenkorb</h1>
                <?php if (count($_SESSION['cart']) == 0): ?>
                    <h3>Ihr Warenkorb ist leer.</h3>
                    <a href="catalog.php"<button class="button">Weiter einkaufen</button></a>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Beschreibung</th>
                                <th>Stückzahl</th>
                                <th>Preis (CHF)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            for ($i = 0; $i < count($items); $i++) {
                                if ($items[$i]["count"] == 0) {
                                    continue;
                                }
                                echo '<tr>';
                                echo '<td>' . $items[$i]["name"] . '</td>';
                                echo '<td align="center">' . $items[$i]["count"] . '</td>';
                                echo '<td align="right">';
                                echo number_format($items[$i]["price"] * $items[$i]["count"], 2);
                                echo '</td>';
                                echo '</tr>';
                                $total += $items[$i]["price"] * $items[$i]["count"];
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th align="right">Total:</th>
                                <th align="right"><?php echo number_format($total, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="catalog.php"<button class="button">Weiter einkaufen</button></a> 
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?empty=1"><button class="button">Warenkorb leeren</button></a><a href="checkout.php"<button class="button">Zur Kasse</button></a>
                <?php endif ?>

            </main>
            <footer>
                <hr>
                <p><a href="mailto:jpm@nobody.xyz?Subject=Quietschenten">Quietschenten-Shop © 2021</a></p>
            </footer>
        </div>
    </body>
</html>
