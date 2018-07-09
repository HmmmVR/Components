<?php

use \PHPUnit\Framework\TestCase;

use \Hmmm\Component\Event\Event;
use \Hmmm\Component\Event\Collection;

class EventTest extends TestCase
{

	public function testDefineEvent()
	{
		$event = new Event("test");
		$final = $event->getName();

		$this->assertSame($final, "test");
	}

	public function testAddCallback()
	{
		$event = new Event("test");

		$event->append(function ($data) {
			echo $data;
		});

		ob_start();
		$event->exec("test");
		$final = ob_get_contents();
		ob_end_clean();

		$this->assertSame($final, "test");
	}

	public function testBeforeAndAfterCallback()
	{
		$event = new Event("test");

		$event->before(function ($data) {
			echo "before";
		});

		$event->after(function ($data) {
			echo "after";
		});

		$event->append(function ($data) {
			echo $data;
		});

		ob_start();
		$event->exec("test");
		$final = ob_get_contents();
		ob_end_clean();

		$this->assertSame($final, "beforetestafter");
	}

	public function testEventCollection()
	{
		$event1 = new Event("First event");
		$event2 = new Event("Second event");
		$event3 = new Event("Last event");
		
		$collection = new Collection();
		
		$collection
			->addEvent($event1)
			->addEvent($event2)
			->addEvent($event3);

		$events = $collection->getEvents();
		$final = count($events);

		$this->assertSame($final, 3);
	}

}
