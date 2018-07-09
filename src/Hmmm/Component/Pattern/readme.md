# Pattern
Extendable and reusable patterns

## Singleton
Extend this class to your own to force yourself to only have one instance.

```php

use \Hmmm\Component\Pattern\Singleton;

class MyClass extends Singleton { }

// Get instance
$myClass = MyClass::singleton();

// Throws error
$myClass = new MyClass();

```

## Pipeline
Pipe data through an array of methods.

```php

use \Hmmm\Component\Pattern\Pipeline;

$pipeline = new Pipeline();

$pipeline->pipe(function ($data){
	return $data += 1;
});

$pipeline->pipe(function ($data){
	return $data += 1;
});

$pipeline->pipe(function ($data){
	return $data += 1;
});

$data = 0;
$pipeline->exec($data);

$result = $pipeline->getResult(); // 3

```
