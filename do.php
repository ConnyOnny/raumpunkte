<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE HTML>
<html>
<head>
	<title>doing stuff</title>
</head>
<body>
	<pre><?php
$id = intval($_GET['id']);
$points = intval($_GET['points']);
if (file_exists("lastdone/$id") && touch ("lastdone/$id")) {
	echo "Aktivität $id als erledigt markiert. Schreib dir $points Punkte auf (falls du die Notwendigkeit der Arbeit nicht selbst hervorgerufen hast).";
} else {
	echo "Fehler bei Markierung. Hat der Webserver Schreibrechte auf das Verzeichnis lastdone?";
}
?></pre>
<a href=".">zurück</a>
</body>
</html>