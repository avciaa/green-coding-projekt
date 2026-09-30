# Green Coding – Mitarbeiter- und Inventartool

## Verbesserungen

### 1. Unnötige Daten mit `SELECT *`

**Problem:**
Mit `SELECT *` werden alle Spalten aus der Datenbank geladen, obwohl nicht alle benötigt werden.

**Verbesserung:**
Nur die tatsächlich benötigten Spalten werden abgefragt.

**Bild:**

<!-- Screenshot Vorher/Nachher hier einfügen -->

---

### 2. Verschachtelte Schleifen bei Geräten

**Problem:**
Für jeden Mitarbeiter werden alle Geräte durchsucht. Bei vielen Mitarbeitern und Geräten entstehen sehr viele Vergleiche.

**Verbesserung:**
Die Zuordnung und Zählung der Geräte wird direkt mit SQL `JOIN` und `COUNT()` durchgeführt.

**Bild:**

<!-- Screenshot Vorher/Nachher hier einfügen -->

---

### 3. Verschachtelte Schleifen bei Abteilungen

**Problem:**
Für jeden Mitarbeiter werden alle Abteilungen durchsucht, um den Abteilungsnamen zu finden.

**Verbesserung:**
Der Abteilungsname wird direkt mit einem SQL `JOIN` geladen.

**Bild:**

<!-- Screenshot Vorher/Nachher hier einfügen -->

---

## Übersicht

| Problem                                                 | Verbesserung                |
| ------------------------------------------------------- | --------------------------- |
| `SELECT *` lädt unnötige Daten                          | Nur benötigte Spalten laden |
| Mitarbeiter × Geräte mit verschachtelten Schleifen      | `JOIN` + `COUNT()`          |
| Mitarbeiter × Abteilungen mit verschachtelten Schleifen | SQL `JOIN`                  |

## Vorher / Nachher

<!-- Bilder hier einfügen -->

<br>

<!-- Bilder hier einfügen -->
