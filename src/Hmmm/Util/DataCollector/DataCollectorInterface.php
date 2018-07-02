<?php

namespace Hmmm\Util\DataCollector;

use \Hmmm\Util\DataCollector\AdapterInterface;

interface DataCollectorInterface
{

	/**
	 * @param object AdapterInterface
	 * @return self
	 */
	public function __construct(AdapterInterface $adapter);

	/**
	 * Get raw collection
	 * @return array
	 */
	public function getCollection();

	/**
	 * Get item from collection
	 * @param string key
	 * @return mixed
	 */
	public function getItem(string $key);

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem(string $key, mixed $data);

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function editItem(string $key, mixed $data);

	/**
	 * @param string key
	 * @return mixed data
	 */
	public function removeItem(string $key);

	/**
	 * @param mixed data
	 * @return self
	 */
	public function appendItem(mixed $data);

}
