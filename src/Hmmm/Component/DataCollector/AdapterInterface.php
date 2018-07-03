<?php

namespace Hmmm\Component\DataCollector;

/**
 * Adapters have to extend AdapterInterface
 * Methods listed in the interface should
 * return the value that has to be saved
 */
interface AdapterInterface
{

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return mixed
	 */
	public function addItem($key, $data);

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return mixed
	 */
	public function editItem($key, $data);

	/**
	 * @param mixed data
	 * @return mixed
	 */
	public function appendItem($data);

}
