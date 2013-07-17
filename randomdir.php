#!/usr/bin/env php
<?php
$chosen_dir = '';
$dirs = 0;

$dir = ".";
$verbose = false;
foreach ($argv as $num=>$val) {
	if ($num == 0)
		continue;

	if ($val[0] == "-")
		switch ($val) {
			case "-v":
				$verbose = true;
				break;
		}
	else
		parsedir($val);
}



function parsedir($dir) {
	global $chosen_dir, $dirs, $verbose;

	if ($dir[strlen($dir) - 1] != '/')
		$dir .= '/';
	$d = opendir($dir);
	if ($d) {
		if ($verbose)
			echo "Parsing $dir\n";

		while ($f = readdir($d)) {
			if ($f == '.' || $f == '..')
				continue;

			if (is_dir($dir . $f) && is_link($dir . $f) === false)
				parsedir($dir . $f . '/');

		}

		if (rand(0, $dirs) == 0)
			$chosen_dir = $dir;

		$dirs++;
		closedir($d);
	}
	else {
		if ($verbose)
			echo "Skipping $dir (error opening)\n";
	}
}

echo $chosen_dir . "\n";
