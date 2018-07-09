<?php

namespace Hmmm\Component\Event;

use \Exception;
use \Hmmm\Component\DataCollector\DataCollector;
use \Hmmm\Component\DataCollector\Adapter\Predefined;

class Collection
{

	/**
	 * Event collection
	 * @var object \Hmmm\Component\DataCollector\DataCollector
	 */
	private $events;

	/**
	 * Create a predefined data collector list with custom type Event
	 * @return self
	 */
	public function __construct()
	{
		$this->events = new DataCollector();
	}

	/**
	 * @param string event name
	 * @param object \Hmmm\Component\Event\Event
	 * @return self
	 */
	public function addEvent(Event $event)
	{
		$this->events->addItem($event->getName(), $event);
		return $this;
	}

	/**
	 * @param string name
	 * @return self
	 */
	public function removeEvent(string $name)
	{
		$this->events->removeItem($name);
		return $this;
	}

	/**
	 * Get event from collection
	 * @param string name
	 * @return object \Hmmm\Component\Event\Event
	 */
	public function getEvent(string $name)
	{
		return $this->events->getItem($name);
	}

	/**
	 * @return array Events
	 */
	public function getEvents()
	{
		return $this->events->getCollection();
	}

	/**
	 * Execute events
	 * @param mixed data
	 * @return self
	 */
	public function exec($data = null)
	{
		$events = $this->events->getCollection();
		foreach ($events as $name => $event)
		{
			$event->exec($data);
		}

		return $this;
	}

}
