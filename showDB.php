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
     . $dsatz["nachname"] . "\n";
     echo "<br>";
   }
   /* Verbindung zur Datenbankdatei wieder lösen */
   $db->close();
   ?>