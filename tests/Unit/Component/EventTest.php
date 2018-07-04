<?php

use \PHPUnit\Framework\TestCase;

use \Hmmm\Component\Event\Event;

class EventTest extends TestCase
{

	public function testDefineEvent()
	{
		$event = new Event("test");
		$final = $event->name;

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

}
