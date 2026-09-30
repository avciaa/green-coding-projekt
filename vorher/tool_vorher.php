<?php

// Internes Mitarbeiter- und Inventartool
// Version: 1.0 - bewusst mit einigen ineffizienten Stellen

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "firma";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// --------------------------------------------------
// Mitarbeiter laden
// --------------------------------------------------

$sql = "SELECT * FROM mitarbeiter";
$result = $conn->query($sql);

$mitarbeiter = [];

while ($row = $result->fetch_assoc()) {
    $mitarbeiter[] = $row;
}

// --------------------------------------------------
// Abteilungen laden
// --------------------------------------------------

$sql = "SELECT * FROM abteilungen";
$result = $conn->query($sql);

$abteilungen = [];

while ($row = $result->fetch_assoc()) {
    $abteilungen[] = $row;
}

// --------------------------------------------------
// Geräte laden
// --------------------------------------------------

$sql = "SELECT * FROM geraete";
$result = $conn->query($sql);

$geraete = [];

while ($row = $result->fetch_assoc()) {
    $geraete[] = $row;
}

// --------------------------------------------------
// Anzahl der Geräte pro Mitarbeiter bestimmen
// --------------------------------------------------

foreach ($mitarbeiter as &$person) {

    $person["anzahl_geraete"] = 0;

    foreach ($geraete as $geraet) {

        if ($geraet["mitarbeiter_id"] == $person["id"]) {
            $person["anzahl_geraete"]++;
        }
    }
}

// --------------------------------------------------
// Abteilungsnamen zuordnen
// --------------------------------------------------

foreach ($mitarbeiter as &$person) {

    foreach ($abteilungen as $abteilung) {

        if ($abteilung["id"] == $person["abteilung_id"]) {
            $person["abteilung_name"] = $abteilung["name"];
        }
    }
}

// --------------------------------------------------
// Mitarbeiter erneut ausgeben
// --------------------------------------------------

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Mitarbeiterverwaltung</title>";
echo "</head>";

echo "<body>";

echo "<h1>Mitarbeiterverwaltung</h1>";

echo "<p>Übersicht aller Mitarbeiter und ihrer Geräte.</p>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>E-Mail</th>";
echo "<th>Abteilung</th>";
echo "<th>Geräte</th>";
echo "</tr>";

foreach ($mitarbeiter as $person) {

    echo "<tr>";

    echo "<td>";
    echo $person["vorname"] . " " . $person["nachname"];
    echo "</td>";

    echo "<td>";
    echo $person["email"];
    echo "</td>";

    echo "<td>";
    echo $person["abteilung_name"];
    echo "</td>";

    echo "<td>";
    echo $person["anzahl_geraete"];
    echo "</td>";

    echo "</tr>";
}

echo "</table>";

echo "<br>";

echo "<form method='post'>";

echo "<label>Suche nach Mitarbeiter:</label>";
echo "<input type='text' name='suche'>";

echo "<button type='submit'>Suchen</button>";

echo "</form>";

echo "</body>";
echo "</html>";

// --------------------------------------------------
// Suche
// --------------------------------------------------

if (isset($_POST["suche"])) {

    $suche = $_POST["suche"];

    echo "<h2>Suchergebnisse</h2>";

    foreach ($mitarbeiter as $person) {

        if (
            strpos(
                strtolower($person["vorname"]),
                strtolower($suche)
            ) !== false
        ) {

            echo "<p>";
            echo $person["vorname"] . " ";
            echo $person["nachname"];
            echo "</p>";
        }
    }
}

// --------------------------------------------------
// Datenbankverbindung schließen
// --------------------------------------------------

$conn->close();

?>