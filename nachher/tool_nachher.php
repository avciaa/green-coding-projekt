<?php

// Internes Mitarbeiter- und Inventartool
// Version: 2.0 - optimiert (Green Coding)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "firma";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// --------------------------------------------------
// Mitarbeiter, Abteilungsname und Geräteanzahl
// in EINER Abfrage laden (JOIN + COUNT statt Schleifen)
// --------------------------------------------------

$sql = "
    SELECT
        m.id,
        m.vorname,
        m.nachname,
        m.email,
        a.name AS abteilung_name,
        COUNT(g.id) AS anzahl_geraete
    FROM mitarbeiter m
    LEFT JOIN abteilungen a ON a.id = m.abteilung_id
    LEFT JOIN geraete g ON g.mitarbeiter_id = m.id
    GROUP BY m.id, m.vorname, m.nachname, m.email, a.name
";

$result = $conn->query($sql);

$mitarbeiter = [];

while ($row = $result->fetch_assoc()) {
    $mitarbeiter[] = $row;
}

// --------------------------------------------------
// Ausgabe
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
    echo htmlspecialchars($person["vorname"] . " " . $person["nachname"]);
    echo "</td>";

    echo "<td>";
    echo htmlspecialchars($person["email"]);
    echo "</td>";

    echo "<td>";
    echo htmlspecialchars($person["abteilung_name"] ?? "-");
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

// --------------------------------------------------
// Suche (bereits geladene Daten, keine neue DB-Abfrage)
// --------------------------------------------------

if (isset($_POST["suche"]) && $_POST["suche"] !== "") {

    $suche = strtolower($_POST["suche"]);

    echo "<h2>Suchergebnisse</h2>";

    foreach ($mitarbeiter as $person) {

        if (strpos(strtolower($person["vorname"]), $suche) !== false) {

            echo "<p>";
            echo htmlspecialchars($person["vorname"] . " " . $person["nachname"]);
            echo "</p>";
        }
    }
}

echo "</body>";
echo "</html>";

// --------------------------------------------------
// Datenbankverbindung schließen
// --------------------------------------------------

$conn->close();

?>