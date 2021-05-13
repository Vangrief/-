<?php
    $dbdir = './db';
    /* Datenbankdatei ausserhalb htdocs öffnen bzw. erzeugen */
    $db = new SQLite3("$dbdir/sq3.db");

    /* Tabelle mit Primärschlüssel erzeugen */
    $db->exec("CREATE TABLE personen (benutzerId, benutzername TEXT PRIMARY KEY, pwssd, vorname , nachname, email, LStrasse, LPlz, LOrt, LLand, BOrders JSON);");

    $db->exec("CREATE TABLE bestellungen (bestId INTEGER PRIMARY KEY AUTOINCREMENT, benutzername , BOrders JSON);");

    /* Drei Datensätze eintragen
    $sqlstr = "INSERT INTO Tpersonen (name, vorname, " . "personalnummer, gehalt, geburtstag) VALUES ";
    $db->query($sqlstr . "('Maier', 'Hans', 6714, 3500, '1962-03-15')");
    $db->query($sqlstr . "('Schmitz', 'Peter', 81343, 3750, '1958-04-12')");
    $db->query($sqlstr . "('Mertens', 'Julia', 2297, 3621.5, '1959-12-30')");
    */

    /* Verbindung zur Datenbankdatei wieder lösen */
    $db->close();
?>