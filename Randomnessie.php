<?php

/**
 * Randomnessie - as random as Nessie appears
 *
 * @version 1.0.0
 * @author  Christoph Heich <mail@christophheich.de>
 */

/**
 * @package Randomnessie
 */
namespace Randomnessie;

/**
 * @package Randomnessie
 */
class Coincidence {
  /**
   * Unmodified probabilities
   *
   * @var array
   */
  protected $_probabilities;

  /**
   * Probabilities
   *
   * @var array
   */
  protected $probabilities;

  /**
   * Unmodified items
   *
   * @var array
   */
  protected $_items;

  /**
   * Items
   *
   * @var array
   */
  protected $items;

	/**
	 * Constructor
	 *
	 * @param array   $items
	 * @param boolean $join  Join multiple items (`true`) or delete it (`false`)
	 */
	public function __construct($items, $join = true) {
    $items_sum = count($items);
    $probabilities = array_fill(0, $items_sum, 1 / $items_sum);

    // Join multiple items
    $unique_keys = array_unique($items);

    // Give each item the same probability
    foreach ($unique_keys as $unique_key) {
      $keys = array_keys($items, $unique_key);
      $key_sum = count($keys);

      if ($key_sum > 1) {
        $prob_multiplier = 1;

        // Keep first item
        while ($key = next($keys)) {
          $prob_multiplier++;

          // Delete unnecessary items but keep the key
          unset($items[$key]);
          unset($probabilities[$key]);
        }

        // Join probabilities of multiple items
        if ($join) {
          $probabilities[reset($keys)] *= $prob_multiplier;
        }
      }
    }

    // Reset array keys
    $probabilities = array_values($probabilities);
    $items = array_values($items);

    $probabilities = $this->normalize($probabilities);

    $this->_probabilities = $probabilities;
    $this->probabilities = $probabilities;
    $this->_items = $items;
    $this->items = $items;
	}

	/**
	 * Get calculated probabilities or set a new array of probabilities
	 *
	 * @param  array $probabilities If set, make sure the array has the same length as
	 *                              the joined items array
	 *
	 * @return array
	 */
	public function probabilities($probabilities = null) {
    if ($probabilities) {
      $this->probabilities = $this->normalize($probabilities);

  		if (count($this->items) != count($this->probabilities)) {
  			throw new CoincidenceException('Length of items have to be the same as probabilities.');
  		}
    }

    return $this->probabilities;
	}

	/**
	 * Random number between 0 and 1 inclusive: [0,1]
	 *
	 * @return float
	 */
	public function number() {
		return mt_rand(0, mt_getrandmax()) / mt_getrandmax(); // [0,1]
	}

	/**
	 * Pick one item randomly
	 *
	 * @param  boolean $exlusive Remove picked item from list for next iteration
	 *
	 * @return mixed
	 */
	public function pick($exlusive = false) {
		$cumulative_probability = 0;
		$items_sum = count($this->items);
		$random = $this->number();

    for ($j = 0; $j < $items_sum; $j++) {
			$cumulative_probability += $this->probabilities[$j];

			if ($random <= $cumulative_probability) {
        $pick = $this->items[$j];

        if ($exlusive) {
  				$key = array_search($pick, $this->items);
  				array_splice($this->items, $key, 1);
  				array_splice($this->probabilities, $key, 1);

          $this->probabilities = $this->normalize($this->probabilities);
  			}

        return $pick;
			}
		}
	}

  /**
	 * Normalize probabilities
	 *
	 * Sum of probabilities should be 1
	 *
	 * @param  array $probabilities
	 *
	 * @return array
	 */
	public function normalize($probabilities) {
		if (!empty($probabilities)) {
			$multiplier = 1 / array_sum($probabilities);

			for ($i = 0; $i < count($probabilities); $i++) {
				$probabilities[$i] *= $multiplier;
			}
		}

    return $probabilities;
	}

	/**
	 * Modify probabilities with a list of "lucky items"
	 * which are multiplied by `$multiplier`.
	 *
	 * Values are between 0 and 1 inclusive. List is normalized.
	 *
	 * @param  array $luckylist  Lucky list
	 * @param  array $multiplier Lucky list multiplier
	 */
	function luckylist($luckylist, $multiplier = 2) {
		$items_sum = count($this->items);

		// Count only affected items
		$lucklist_sum = count(array_intersect($this->items, $luckylist));

		for ($i = 0; $i < $items_sum; $i++) {
			$this->probabilities[$i] = 1 / ($items_sum + ($lucklist_sum * ($multiplier - 1)));

			if (in_array($this->items[$i], $luckylist)) {
				$this->probabilities[$i] *= $multiplier;
			}
		}
	}

  /**
   * Restore items and probabilities
   */
  public function restore() {
    $this->items = $this->_items;
    $this->probabilities = $this->_probabilities;
  }
}

/**
 * @package Randomnessie
 */
class CoincidenceException extends \Exception {}
