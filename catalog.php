<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['buy'])) {
    // Add item to the end of the $_SESSION['cart'] array
    $_SESSION['cart'][] = $_GET['buy'];
    header('location: ' . $_SERVER['PHP_SELF'] . '?' . SID);
    exit();
}
?>

<html lang="de">
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
                    <li><a href="catalog.php"><b>Katalog</b></a></li>
                    <li><a href="cart.php"><i class="fa fa-shopping-cart" style="font-size:20px"></i> (<?php echo count($_SESSION['cart']); ?>)</a></li>
                </ul>
            </nav>
            <main>
                <h1>Produkte-Katalog</h1>
                <?php
                $items = array(
                    'Quietschente rot',
                    'Quietschente blau',
                    'Quietschente gelb',
                    'Quietschente silber',
                    'Queitschente gold'
                );
                $prices = array(6.95, 6.95, 6.95, 8.95, 11.95);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Beschreibung</th>
                            <th>Preis</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($items); $i++) {
                            echo '<tr>';
                            echo '<td>' . $items[$i] . '<img src="img/ente' . $i . '.jpg"</td>';
                            echo '<td>CHF ' . number_format($prices[$i], 2) . '</td>';
                            echo '<td><a href="' . $_SERVER['PHP_SELF'] .
                            '?buy=' . $i . '"><button class="button">Kaufen '
                                    . '<i class="fa fa-shopping-cart" style="font-size:24px"></i></button></a></td>';
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
            <footer>
                <hr>
                <p><a href="mailto:jpm@nobody.xyz?Subject=Quietschenten">Quietschenten-Shop © 2021</a></p>
            </footer>
        </div>
    </body>
</html>
