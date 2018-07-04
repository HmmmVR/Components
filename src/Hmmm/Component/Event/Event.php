<?php

namespace Hmmm\Component\Event;

use \Hmmm\Component\DataCollector\DataCollector;
use \Hmmm\Component\DataCollector\Adapter\Predefined;

class Event
{
	/**
	 * Event name
	 * @var string
	 */
	public $name;

	/**
	 * DataCollector
	 * @var object \Hmmm\Component\DataCollector\DataCollector
	 */
	private $collector;

	/**
	 * Call before exec
	 * @var callable
	 */
	private $before;

	/**
	 * Call after exec
	 * @var callable
	 */
	private $after;

	/**
	 * Constructor
	 * @param string event name
	 */
	public function __construct(string $name)
	{
		$this->name = $name;
		$adapter = new Predefined("callable");
		$this->collector = new DataCollector($adapter);
	}

	/**
	 * Set call before exec
	 * @param callable
	 * @return self
	 */
	public function before(callable $callback)
	{
		$this->before = $callback;
		return $this;
	}

	/**
	 * Set call after exec
	 * @param callable
	 * @return self
	 */
	public function after(callable $callback)
	{
		$this->after = $callback;
		return $this;
	}

	/**
	 * Append callback to event
	 * @param callable
	 * @return self
	 */
	public function append(callable $callback)
	{
		$this->collector->appendItem($callback);
		return $this;
	}

	/**
	 * Execute event
	 * @param mixed data passed into callback
	 * @return self
	 */
	public function exec($data = null)
	{
		$callbacks = $this->collector->getCollection();

		if (empty($callbacks))
		{
			return $this;
		}

		if (is_callable($this->before))
		{
			call_user_func($this->before, $data);
		}

		foreach ($callbacks as $callback)
		{
			$callback($data);
		}

		if (is_callable($this->after))
		{
			call_user_func($this->after, $data);
		}

		return $this;
	}
}
