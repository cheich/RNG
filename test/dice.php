<?php

use Cheich\RNG\Coincidence;
use Cheich\RNG\CoincidenceException;

require_once '../src/Coincidence.php';
require_once '../src/CoincidenceException.php';

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
