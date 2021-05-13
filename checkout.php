<!DOCTYPE html>

<?php
session_start();

$vorname = "";
    $nachname = "";
    $email = "";
    $LStrasse = "";
    $LPlz = "";
    $LOrt = "";
    $LLand = "";

if (isset($_SESSION['currentBenutzer'])) {
    echo $_SESSION['currentBenutzer'];

    $dbdir = './db';
        /* Datenbankdatei ausserhalb htdocs öffnen bzw. erzeugen */
    $db = new SQLite3("$dbdir/sq3.db");

    if (isset($_REQUEST['firstname']) && $_POST['firstname'] != "") {                
        //$con = new PDO("$dbdir/sq3.db");
        $db->exec('UPDATE personen SET '.
        'vorname = "'.$_REQUEST['firstname'].'",'.
        'nachname = "'.$_REQUEST['lastname'].'",'.
        'email = "'.$_REQUEST['email'].'",'.
        'LStrasse = "'.$_REQUEST['address'].'",'.
        'LPlz = "'.$_REQUEST['plz'].'",'.
        'LOrt = "'.$_REQUEST['ort'].'",'.
        'LLand = "'.$_REQUEST['country'].'"'.
        ' WHERE benutzername = "'.$_SESSION['currentBenutzer'].'";');

        /*
        echo 'UPDATE personen SET '.
        'vorname = "'.$_REQUEST['firstname'].'",'.
        'nachname = "'.$_REQUEST['lastname'].'",'.
        'email = "'.$_REQUEST['email'].'",'.
        'LStrasse = "'.$_REQUEST['address'].'",'.
        'LPlz = "'.$_REQUEST['plz'].'",'.
        'LOrt = "'.$_REQUEST['ort'].'",'.
        'LLand = "'.$_REQUEST['country'].'"'.
        ' WHERE benutzername = "'.$_SESSION['currentBenutzer'].'";';*/

        $sqlstr = "INSERT INTO bestellungen (bestId, benutzername, BOrders) VALUES ";
        $db->query($sqlstr . "(null, '".$_SESSION['currentBenutzer']."', '".json_encode($_SESSION['cart'])."')");

        unset($_POST);
        unset($_REQUEST);
        unset($_SESSION['cart']);
        header("Location: index.php");
    } else {
        $res = $db->query('SELECT * FROM personen WHERE benutzername = "'.$_SESSION['currentBenutzer'].'"');
        while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
            $vorname = $dsatz["vorname"];
            $nachname = $dsatz["nachname"];
            $email = $dsatz["email"];
            $LStrasse = $dsatz["LStrasse"];
            $LPlz = $dsatz["LPlz"];
            $LOrt = $dsatz["LOrt"];
            $LLand = $dsatz["LLand"];
        }
    }
} else {  
    unset($_SESSION['currentBenutzer']);
    header("Location: login.php");
    exit;
}

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
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Ubuntu:700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
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
                <li><a href="cart.php"><i class="fa fa-shopping-cart" style="font-size:20px"></i> <?php echo count($_SESSION['cart']); ?></a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
        <main>
            <h1>Checkout</h1>
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Warenkorb</span>
                        <span class="badge badge-secondary badge-pill"> (<?php echo count($_SESSION['cart']); ?>)</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                        $total = 0;
                        for ($i = 0; $i < count($items); $i++) {
                            if ($items[$i]["count"] == 0) {
                                continue;
                            }
                            echo '<li class="list-group-item d-flex justify-content-between lh-condensed">';
                            echo  '<div>';
                            echo  '<h6 class="my-0">' . $items[$i]["name"] . '</h6>';
                            echo '<small class="text-muted">' . $items[$i]["count"] . "x" . '</small>';
                            echo '</div>';
                            echo '<span class="text-muted">' . number_format($items[$i]["price"] * $items[$i]["count"], 2) . '</span>';
                            echo '</li>';
                            $total += $items[$i]["price"] * $items[$i]["count"];
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (CHF)</span>
                            <strong><?php echo number_format($total, 2); ?></strong>
                        </li>
                    </ul>

                    <form class="card p-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Gutschein">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">Einlösen</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Adresse</h4>
                    <form class="needs-validation" novalidate="" action="checkout.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname">Vorname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" required="" value="<?php echo $vorname; ?>">
                                <div class="invalid-feedback">
                                    gültiger Vorname is benötigt.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Nachname</label>
                                <input type="text" class="form-control" id="name" name="lastname" placeholder="" required="" value="<?php echo $nachname; ?>">
                                <div class="invalid-feedback">
                                    gültiger Nachname is benötigt.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@muster.com" value="<?php echo $email; ?>">
                            <div class="invalid-feedback">
                                bitte geben sie eine gültige email address ein um versand updates zu erhalten.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Adresse</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Mustertrasse 123" required="" value="<?php echo $LStrasse; ?>">
                            <div class="invalid-feedback">
                                bitte geben sie eine gültige Adresse ein.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="postleitzahl">Postleitzahl</label>
                                <input type="text" class="form-control" id="postleitzahl" name="plz" placeholder="" required="" value="<?php echo $LPlz; ?>">
                                <div class="invalid-feedback">
                                    Postleitzahl wird benötigt.
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="ort">Ort</label>
                                <input type="text" class="form-control" id="ort" name="ort" placeholder="" required="" value="<?php echo $LOrt; ?>">
                                <div class="invalid-feedback">
                                    Ort wird benötigt.
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="country">Land</label>
                                <select class="custom-select d-block w-100" id="country" name="country" required="">
                                    <option value="" selected="selected">Auswählen...</option>
                                    <option <?php if ($LLand == 'Vereinigte Staaten') echo ' selected="selected"'; ?>>Vereinigte Staaten</option>
                                    <option <?php if ($LLand == 'Schweiz') echo ' selected="selected"'; ?>>Schweiz</option>
                                    <option <?php if ($LLand == 'Deutschland') echo ' selected="selected"'; ?>>Deutschland</option>
                                    <option <?php if ($LLand == 'Sowjetunion') echo ' selected="selected"'; ?>>Sowjetunion</option>
                                </select>
                                <div class="invalid-feedback">
                                    bitte wählen sie ein gültiges Land aus.
                                </div>
                            </div>

                        </div>
                        <hr class="mb-4">

                        <h4 class="mb-3">Zahlung</h4>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="checked" required="">
                                <label class="custom-control-label" for="credit">Kreditkarte</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                                <label class="custom-control-label" for="debit">Bankkarte</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="twint" name="paymentMethod" type="radio" class="custom-control-input" required="">
                                <label class="custom-control-label" for="twint">Twint</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Name</label>
                                <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required="">
                                <small class="text-muted">Ganzer name wie auf der Karte</small>
                                <div class="invalid-feedback">
                                    Name wird benötigt.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Kreditkartennummer</label>
                                <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Kreditkartennummer wird benötigt.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Ablaufdatum</label>
                                <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Ablaufdatum wird benötigt.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required="">
                                <div class="invalid-feedback">
                                    CVV wird benötigt.
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Weiter zum Checkout</button>
                    </form>
                </div>
            </div>

        </main>
        <footer>
            <hr>
            <p><a href="mailto:jpm@nobody.xyz?Subject=Quietschenten">Quietschenten-Shop © 2021</a></p>
        </footer>
    </div>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';

            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>