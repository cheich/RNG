<?php

use Randomnessie\Coincidence;
use Randomnessie\CoincidenceException;

require_once '../Randomnessie.php';

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<
// TEST SETTINGS
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<

$items = [
	'item #0',
	'item #1',
	'item #2',
	'item #3',
	'item #4',
	'item #5'
];

$probabilities = [
	0.25,
	0.25,
	0.5,
	0.5,
	0.75,
	1
];

$loops = 1000;

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>
// TEST SETTINGS
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>

echo '<h2>Setup</h2>';

echo "<strong>Loops:</strong> {$loops}";

echo '<h4>Items</h4>';
echo '<pre>';
print_r($items);
echo '</pre>';

echo '<h4>Probabilities</h4>';
echo 'This list will be automatically normalized.';
echo '<pre>';
print_r($probabilities);
echo '</pre>';

try {
  $picks = array();
	$random = new Coincidence($items);
	$random->probabilities($probabilities);

  echo '<h2>Result</h2>';
  for ($i = 0; $i < $loops; $i++) {
		$picks[]= $random->pick();
	}

  $items_sum = count($items);
  $counts = array_count_values($picks);

  echo '<h3>Normalized probabilities</h3>';
  echo '<pre>';
  print_r($random->probabilities());
  echo '</pre>';

  echo '<h3>Picks</h3>';
  echo '<pre>';
  foreach ($items as $item) {
    echo "{$item}: <strong>{$counts[$item]}</strong><br />";
  }
  echo '</pre>';

  echo '<h3>Percentage</h3>';
  echo '<pre>';
  foreach ($items as $item) {
    $percentage = $counts[$item] / $loops;
    echo "{$item}: <strong>{$percentage}</strong><br />";
  }
  echo '</pre>';

} catch (CoincidenceException $e) {

	echo '<strong>Caught exception:</strong> ' . $e->getMessage();

}
