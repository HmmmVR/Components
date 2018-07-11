<?php

namespace TestData;

use \Hmmm\Component\Terminal\CommandInterface;

class __Command implements CommandInterface
{

	private $name = "TestCommand";

	private $arguments;

	private $options;

	public function __construct(array $arguments, array $options = [])
	{
		$this->arguments = $arguments;
		$this->options = $options;
	}

	public function getName()
	{
		return $this->name;
	}

	public function checkOptions(string $s)
	{
		$return = false;
		foreach($this->options as $option)
		{
			if ($option == $s)
			{
				$return = true;
			}
		}

		return $return;
	}

	public function exec()
	{
		if (isset($this->arguments[0]))
		{
			echo $this->arguments[0];
		}

		if ($this->checkOptions("test"))
		{
			echo "test";
		}

		if ($this->checkOptions("option"))
		{
			echo "option";
		}
	}

}
