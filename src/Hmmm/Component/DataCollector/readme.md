# DataCollector

Collect data in a class instance

## WHY????
Mainly to have a predictable and strict data collection. It's great when you work with multiple people so they can except the type and maybe data. Also nice for debugging, less logging.

## Classes

### DataCollector
Main class, manages the data and injects adapters

### AdapterInterface
Interface that is neccesairy to be implemented for all adapters. This is to give all classes the same class type and to force adapters to use the neccesairy methods

### Adapter -> Predefined
Optional type checker for your data. Keep data the types you predefine.

### usage

```php
use \Hmmm\Component\DataCollector\DataCollector;

// optional, predefine types
use \Hmmm\Component\DataCollector\Adapter\Predefine;

new Predefine(["test" => "string"]);

// Initialize data collector
$collector = new DataCollector();

// Add item to collection
$collector->addItem("test", "this must be a string because it's predefined"); // -> self

// Get item from collection
$collector->getItem("test"); // -> "this must be a string because it's predefined"

// Get full collection
$collector->getCollection(); // ["test" => "this must be a string because it's predefined"]

// Edit value
$collector->editItem("test", "now it's a different value"); // -> self

// Remove item from collection
$collector->removeItem("test"); // -> self
```
