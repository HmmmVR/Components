# Event

Central event manager, inject and watch events

## Usage
```php
use \Hmmm\Component\Event\Event;

$event = new Event("MyEvent");

// before execution
$event->before(function ($data) {
	echo "before\n";
});

// after execution
$event->after(function ($data) {
	echo "after\n"
});

// 1
$event->append(function ($data) {
	echo "method 1\n";
});

// 2
$event->append(function ($data) {
	echo "method 2\n";
});

// 3
$event->append(function ($data) {
	echo "method 3\n";
});

$event->exec("some data");

/*
results in:
before
method 1
method 2
method 3
after
*/

$collection = new Collection();
$collection->addEvent($event);
$collection->getEvent("MyEvent");
$collection->removeEvent("MyEvent");
$collection->exec("some data"); // executes all events in collection

```
