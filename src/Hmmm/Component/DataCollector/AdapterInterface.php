<?php

namespace Hmmm\Component\DataCollector;

interface AdapterInterface
{

	/**
	 * Add item to collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function addItem($key, $data);

	/**
	 * Edit item already in collection
	 * @param string key
	 * @param mixed data
	 * @return self
	 */
	public function editItem($key, $data);

	/**
	 * @param mixed data
	 * @return self
	 */
	public function appendItem($data);

}
