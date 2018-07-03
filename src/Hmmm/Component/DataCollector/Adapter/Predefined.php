<?php

namespace Hmmm\Component\DataCollector\Adapter;

use Hmmm\Component\DataCollector\AdapterInterface;

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
	 * @param array schema
	 * @return self
	 */
	public function __construct(array $schema)
	{
		$this->schema = $schema;
	}

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem($key, $data)
	{

	}

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function editItem($key, $data)
	{

	}

	/**
	 * @param mixed data
	 * @return self
	 */
	public function appendItem($data)
	{

	}

}
