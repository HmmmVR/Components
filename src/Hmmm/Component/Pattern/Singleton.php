<?php

namespace Hmmm\Component\Pattern;

class Singleton
{
	/**
	 * Instance
	 * @var object
	 */
    protected static $instance;
	
	/**
	 * Make clone private
	 */
	private function __clone() { } 

	/**
	 * Make constructor private
	 */
	private function __construct() { } 

	/**
	 * Make wakeup private
	 */
	private function __wakeup() { }

	/**
	 * Call singleton to get the instance
	 * @return object
	 */
	final public static function singleton()
	{
		if (!isset(static::$instance))
		{
			static::$instance = new static();
		}

		return static::$instance;
	}
}
