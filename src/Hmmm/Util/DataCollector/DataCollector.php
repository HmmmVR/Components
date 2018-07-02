<?php

namespace Hmmm\Util\DataCollector;

use \Exception;
use \Hmmm\Util\DataCollector\AdapterInterface;
use \Hmmm\Util\DataCollector\DataCollectorInterface;

class DataCollector implements DataCollectorInterface
{

	/**
	 * Collection of data
	 * @var array
	 */
	private $collection;

	/**
	 * Custom adapter
	 * @var object \Hmmm\Util\DataCollector\AdapterInterface
	 */
	private $adapter;

	/**
	 * @param object \Hmmm\Util\DataCollector\AdapterInterface
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
	public function getItem(string $key)
	{
		if ($this->adapter != null && method_exists($this->adapter, 'getItem'))
		{
			return $this->adapter->getItem($key);
		}

		return $this->collection[$key];
	}

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem(string $key, mixed $data)
	{
		if (isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} already exists");
		}

		if ($this->adapter != null && method_exists($this->adapter, 'addItem'))
		{
			$this->adapter->addItem($key, $data);
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
	public function editItem(string $key, mixed $data)
	{
		if (!isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} does not exist");
		}

		if ($this->adapter != null && method_exists($this->adapter, 'editItem'))
		{
			$this->adapter->editItem($key, $data);
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
	public function removeItem(string $key)
	{
		if (!isset($this->collection[$key]))
		{
			throw new Exception("Key {$key} does not exist");
		}

		if ($this->adapter != null && method_exists($this->adapter, 'removeItem'))
		{
			$this->adapter->removeItem($key);
		}
		else
		{
			unset($this->collection[$key]);
			
			if (is_numeric($key))
			{
				$this->collection = array_values($this->collection);
			}
		}

		return $this;
	}

	/**
	 * Append data to list
	 * @param mixed data
	 * @return self
	 */
	public function appendItem(mixed $data)
	{
		if ($this->adapter != null && method_exists($this->adapter, 'appendItem'))
		{
			$this->adapter->appendItem($data);
		}
		else
		{
			$this->collection[] = $data;
		}

		return $this;
	}

}
