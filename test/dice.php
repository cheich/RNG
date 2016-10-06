<?php

use Randomnessie\Coincidence;
use Randomnessie\CoincidenceException;

require_once '../Randomnessie.php';

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<
// TEST SETTINGS
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<

$dice = [
	'1',
	'2',
	'3',
	'4',
	'5',
	'6'
];

$pick_count = 2;

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>
// TEST SETTINGS
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>

try {
	$random = new Coincidence($dice);

	echo "<h4>1 dice</h4>";
  echo $random->pick() . '<br />';

  echo "<h4>{$pick_count} dice</h4>";
	for ($i = 0; $i < $pick_count; $i++) {
		echo $random->pick() . "<br />";
	}

} catch (CoincidenceException $e) {

	echo '<strong>Caught exception:</strong> ' . $e->getMessage();

}
