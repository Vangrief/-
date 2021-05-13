<!DOCTYPE html>

<?php
$dbdir = './db';
  /* Datenbankdatei öffnen bzw. erzeugen */
  $db = new SQLite3("$dbdir/sq3.db");

  $res = $db->query("SELECT * FROM personen");

  /* Abfrageergebnis ausgeben */
  while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
     echo $dsatz["benutzerId"] . ", "
     . $dsatz["benutzername"] . ", "
     . $dsatz["pwssd"] . ", "
     . $dsatz["vorname"] . ", "
     . $dsatz["nachname"] . ", "
     . $dsatz["email"] . ", "
     . $dsatz["LStrasse"] . ", "
     . $dsatz["LPlz"] . ", "
     . $dsatz["LOrt"] . ", "
     . $dsatz["LLand"] . ", "
     . $dsatz["BOrders"] . "\n";
     echo "<br>";
   }

   $res = $db->query("SELECT * FROM bestellungen");

  /* Abfrageergebnis ausgeben */
  while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
     echo $dsatz["bestId"] . ", "
     . $dsatz["benutzername"] . ", "
     . $dsatz["BOrders"] . "\n";
     echo "<br>";
   }

   /* Verbindung zur Datenbankdatei wieder lösen */
   $db->close();
   ?>