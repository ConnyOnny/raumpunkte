<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Raumpunkte - Hackerspace Saarbrücken</title>
	<style type="text/css">
	body {
		font-family: sans-serif;
		font-stretch: condensed;
	}
	.todotask, .donetask {
		border: 1px solid black;
		margin: 0.4em;
		padding: 0.3em;
	}
	.todotask {
		background: #eee;
	}
	.donetask {
		background: #aaa;
		color: #333;
		font-style: italic;
	}
	</style>
</head>
<body>
	<h1>Raumpunkte - Hackerspace Saarbrücken</h1>
	<?php
	$dateformat = 'l, Y-m-d G:i';
	$xmlobj = simplexml_load_file('table.xml');
	if (!$xmlobj) {
		echo '<pre>invalid table.xml\n';
		foreach(libxml_get_errors() as $error) {
			echo "\t", $error->message;
		}
		echo '</pre>';
		die();
	}
	$i = 0;
	foreach ($xmlobj->task as $task) {
		if (!file_exists("lastdone/$i"))
			touch("lastdone/$i");
		$lastdone = filemtime("lastdone/$i");
		$interval = intval($task->interval);
		$todothen = $lastdone+$interval;
		$isdue = ($todothen < time());
		$basepoints = $task->points;
		if ($isdue) {
			$pointsnow = $basepoints;
			$duefor = time() - $todothen;
			$dueintervals = $duefor / $interval;
			for ($j=1; $j<$dueintervals; $j++) {
				$pointsnow *= 1.1; // +10%
			}
			$pointsnow = round($pointsnow);
		} else {
			$pointsnow = 0;
		}
		echo '<div class="', ($isdue ? 'todo' : 'done') ,'task">';
		echo '<h2>', $task->name, '</h2>';
		echo '<ul>';
		echo '<li>Zuletzt getan: ', date($dateformat, $lastdone), '</li>';
		echo '<li>Turnusmäßig wieder tun: ', date($dateformat, $todothen), '</li>';
		echo '<li>Basispunktzahl: ', $basepoints, '</li>';
		echo '<li>Derzeitiger Punktwert: <b>', $pointsnow, '</b></li>';
		echo '<a href="do.php?id=', $i, '&points=', max($pointsnow,$basepoints), '">';
		if ($isdue) {
			echo 'Hab ich gerade getan';
		} else {
			echo 'Hab ich gerade getan weil es nötig war (Punkte bitte nur aufschreiben, falls du die Not nicht selbst verursacht hast)';
		}
		echo '</a>';
		echo '</ul>';
		echo '</div>';
		$i++;
	}
	?>
</body>
</html>