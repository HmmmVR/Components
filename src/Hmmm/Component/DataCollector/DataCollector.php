<?php

namespace Hmmm\Component\DataCollector;

use \Exception;
use \Hmmm\Component\DataCollector\AdapterInterface;

class DataCollector
{

	/**
	 * Collection of data
	 * @var array
	 */
	private $collection;

	/**
	 * Custom adapter
	 * @var object \Hmmm\Component\DataCollector\AdapterInterface
	 */
	private $adapter;

	/**
	 * @param object \Hmmm\Component\DataCollector\AdapterInterface
	 * @return self
	 */
	public function __construct(AdapterInterface $adapter = null)
	{
		$this->collection = [];

		if ($adapter != null)
		{
			$this->adapter = $adapter;
		}
	}

	/**
	 * Get adapter
	 * @return object \Hmmm\Component\DataCollector\AdapterInterface
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}

	/**
	 * Get raw collection
	 * @return array
	 */
	public function getCollection()
	{
		return $this->collection;
	}

	/**
	 * Get collection as object
	 * @return object
	 */
	public function getCollectionAsObject()
	{
		return (object) $this->collection;
	}

	/**
	 * Get item from collection
	 * @param string key
	 * @return mixed
	 */
	public function getItem($key)
	{
		if (!isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} does not exist");
		}

		return $this->collection[$key];
	}

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem($key, $data)
	{
		if (isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} already exists");
		}

		if ($this->adapter != null && method_exists($this->adapter, 'addItem'))
		{
			$this->collection[$key] = $this->adapter->addItem($key, $data);
		}
		else
		{
			$this->collection[$key] = $data;
		}

		return $this;
	}

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function editItem($key, $data)
	{
		if (!isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} does not exist");
		}

		if ($this->adapter != null && method_exists($this->adapter, 'editItem'))
		{
			$this->collection[$key] = $this->adapter->editItem($key, $data);
		}
		else
		{
			$this->collection[$key] = $data;
		}

		return $this;
	}

	/**
	 * Remove item from list or collection
	 * @param string key
	 * @return mixed data
	 */
	public function removeItem($key)
	{
		if (!isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} does not exist");
		}

		unset($this->collection[$key]);

		if (!is_numeric($key))
		{
			$this->collection = array_values($this->collection);
		}

		return $this;
	}

	/**
	 * Append data to list
	 * @param mixed data
	 * @return self
	 */
	public function appendItem($data)
	{
		if ($this->adapter != null && method_exists($this->adapter, 'appendItem'))
		{
			$this->collection[] = $this->adapter->appendItem($data);
		}
		else
		{
			$this->collection[] = $data;
		}

		return $this;
	}

}
