<?php

namespace Hmmm\Component\Pattern;

class Pipeline
{
	/**
	 * Callables
	 * @var array
	 */
	private $pipes;

	/**
	 * Data to pipe
	 * @var mixed
	 */
	private $data;

	/**
	 * Final dara
	 * @var mixed
	 */
	private $result;

	/**
	 * Create array on new
	 * @return self
	 */
	public function __construct()
	{
		$this->pipes = [];
	}

	/**
	 * Add pipe
	 * @param callable pipe
	 * @return self
	 */
	public function pipe(callable $pipe)
	{
		$this->pipes[] = $pipe;
		return $this;
	}

	/**
	 * Execute pipeline
	 * @param mixed data
	 * @return self
	 */
	public function exec($data)
	{
		$this->data = $data;
		foreach ($this->pipes as $pipe)
		{
			$this->data = $pipe($this->data);
		}

		$this->result = $this->data;

		return $this;
	}

	/**
	 * Get final result
	 * @return mixed final result
	 */
	public function getResult()
	{
		return $this->result;
	}

}
