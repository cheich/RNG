<?php

use Randomnessie\Coincidence;
use Randomnessie\CoincidenceException;

require_once '../Randomnessie.php';

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<
// TEST SETTINGS
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<

$items = [
	'item #0',
	'item #0',
	'item #1',
	'item #2',
	'item #3',
	'item #4',
	'item #5',
	'item #5',
	'item #5',
	'item #6'
];

$luckylist = [
	'item #3',
	'item #5',
	'item #999'
];

$luckylist_multiplier = 2;
$pick_count = 3;
$join_multiple_items = true;

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>
// TEST SETTINGS
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>

echo '<h2>Setup</h2>';

echo "<strong>Number of picks in loops:</strong> {$pick_count} <br />";

echo '<strong>Join multiple items:</strong> ';
echo $join_multiple_items ? 'true' : 'false';

echo "<br /><strong>Lucky list mulitplier:</strong> {$luckylist_multiplier}";

echo '<h4>Items</h4>';
echo '<pre>';
print_r($items);
echo '</pre>';

echo '<h4>Lucky list</h4>';
echo '<pre>';
print_r($luckylist);
echo '</pre>';

try {
	$random = new Coincidence($items, $join_multiple_items);

	echo '<h2>Probabilities</h2>';
	echo '<pre>';
	print_r($random->probabilities());
	echo '</pre>';
	echo '<strong>Array sum (should be 1):</strong> ' . array_sum($random->probabilities());

	echo '<h4>Probabilities with lucky list</h4>';
	$random->luckylist($luckylist, $luckylist_multiplier);
	echo '<pre>';
	print_r($random->probabilities());
	echo '</pre>';
	echo '<strong>Array sum (should be 1):</strong> ' . array_sum($random->probabilities());
	$random->restore();

	echo '<h2>Random picks from list</h2>';

	echo '<h4>One random pick</h4>';
	echo $random->pick();

	echo "<h4>{$pick_count} exclusive picks</h4>";
	for ($i = 0; $i < $pick_count; $i++) {
		echo $random->pick(true) . "<br />";
	}
	$random->restore();

	echo "<h4>{$pick_count} inclusive picks</h4>";
	for ($i = 0; $i < $pick_count; $i++) {
		echo $random->pick() . '<br />';
	}
	$random->restore();

	$random->luckylist($luckylist, $luckylist_multiplier);

	echo '<h2>Random picks from list with lucky list</h2>';

	echo '<h4>One random pick</h4>';
	echo $random->pick();

	echo "<h4>{$pick_count} exclusive picks</h4>";
	for ($i = 0; $i < $pick_count; $i++) {
		echo $random->pick(true) . "<br />";
	}
	$random->restore();

	echo "<h4>{$pick_count} inclusive picks</h4>";
	for ($i = 0; $i < $pick_count; $i++) {
		echo $random->pick() . "<br />";
	}
	$random->restore();

} catch (CoincidenceException $e) {

	echo '<strong>Caught exception:</strong> ' . $e->getMessage();

}
