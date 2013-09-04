<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE HTML>
<html>
<head>
	<title>administer stuff</title>
</head>
<body>
	<p>Note: Dies ist nicht Teil des finalen Programms und nur zum Vorführen und Testen gedacht.</p>
	<pre><?php
	if (isset($_GET['id']) && isset($_GET['when'])) {
		$id = intval($_GET['id']);
		$when = intval(strtotime($_GET['when']));
		if (file_exists("lastdone/$id") && touch ("lastdone/$id", $when)) {
			echo "Aktivität $id als erledigt am $when markiert.";
		} else {
			echo "Fehler bei Markierung. Hat der Webserver Schreibrechte auf das Verzeichnis lastdone? Wurde ein gültiges Datum gegeben?";
		}
	}
?></pre>
<a href=".">zurück</a>
<p>
<form action="admin.php" method="get">
Aufgaben-ID (von 0 bis 6): <input type="text" name="id"/>
Zeitpunkt der Ausführung: <input type="text" name="when"/>
<input type="submit"/>
</form>
</p>
</body>
</html>