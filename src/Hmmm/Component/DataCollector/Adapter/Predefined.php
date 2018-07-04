<?php

namespace Hmmm\Component\DataCollector\Adapter;

use \Exception;
use \Hmmm\Component\DataCollector\AdapterInterface;

/**
 * Set data storage predefined keys and types
 */
class Predefined implements AdapterInterface
{
	/**
	 * Schema of predefined keys and types
	 * @var array
	 */
	private $schema;

	/**
	 * Set of available types
	 * @var array
	 */
	private $types;

	/**
	 * Set to true if non-assoc array
	 * @var bool
	 */
	private $isList = false;

	/**
	 * @param array schema
	 * @return self
	 */
	public function __construct($schema)
	{
		if (is_string($schema))
		{
			$this->isList = true;
		}

		$this->setTypes();

		$this->schema = $schema;
	}

	/**
	 * Add type to list
	 * @param string type name
	 * @param callable check function
	 * @return self
	 */	
	public function addType($name, $callback)
	{
		$this->types[$name] = $callback;
		return $this;
	}

	/**
	 * Set default types
	 * @return self
	 */
	private function setTypes()
	{
		$this->types['string'] = function ($v) { return is_string($v); };
		$this->types['int'] = function ($v) { return is_int($v); };
		$this->types['bool'] = function ($v) { return is_bool($v); };
		$this->types['array'] = function ($v) { return is_array($v); };
		$this->types['object'] = function ($v) { return is_object($v); };
		$this->types['numeric'] = function ($v) { return is_numeric($v); };
		$this->types['callable'] = function ($v) { return is_callable($v); };
		$this->types['float'] = function ($v) { return is_float($v); };
		$this->types['alphabetic'] = function ($v) { return (preg_match("/^[a-z]+$/m", strtolower($v)) === 1); };
		$this->types['alphanumeric'] = function ($v) { return (preg_match("/^[a-z]+$/m", strtolower($v)) === 1); };

		return $this;
	}

	/**
	 * Check if type is correct
	 * if isList key becomes data
	 * @param string type name
	 * @param mixed value to check
	 * @param string pattern to match
	 * @return bool
	 */
	private function checkType($key, $data = null)
	{
		if ($this->isList)
		{
			// set first param as data
			$data = $key;
		}

		if (!$this->isList && !isset($this->schema[$key]))
		{
			throw new Exception("Key does not exist {$key}");
		}

		$type = $this->isList ? $this->schema : $this->schema[$key];

		if (!isset($this->types[$type]))
		{
			throw new Exception("Type {$type} is not set");
		}

		return call_user_func($this->types[$type], $data);
	}

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem($key, $data)
	{
		$type = gettype($data);

		if (!$this->checkType($key, $data))
		{
			throw new Exception("Wrong type of {$type} for key {$key}");
		}

		return $data;
	}

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function editItem($key, $data)
	{
		$type = gettype($data);

		if (!$this->checkType($key, $data))
		{
			throw new Exception("Wrong type of {$type} for key {$key}");
		}

		return $data;
	}

	/**
	 * @param mixed data
	 * @return self
	 */
	public function appendItem($data)
	{
		$type = gettype($data);

		if (!$this->checkType($data))
		{
			throw new Exception("Wrong type of {$type} for key {$key}");
		}

		return $data;
	}

}
