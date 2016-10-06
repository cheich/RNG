# Randomnessie - as random as Nessie appears

## Features

- Pick random items from lists
- Set probability for each item or via a lucky list
- Calculate probabilities

## Example

```php
try {
  $random = new Coincidence($items, true);

  // Get probabilities as array
  $random->probabilities();

  // Set some lucky items with a multiplier of 2
  $random->luckylist($luckylist, 2);

  // Get new probabilities as array
  $random->probabilities();

  // Pick an item randomly
  $random->pick();

  // Pick an item randomly and remove it from the list
  $random->pick(true);

  // Restore items and probabilities
  $random->restore();

  // Random number
  $random->number();
} catch (CoincidenceException $e) {
  echo 'Something went wrong...';
}
```
