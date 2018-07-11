<?php

namespace Hmmm\Component\Terminal;

use \Hmmm\Component\DataCollector\DataCollector;

class Terminal
{

	/**
	 * Command name to be executed
	 * @var string
	 */
	private $name;

	/**
	 * List of possible commands
	 * @var array
	 */
	private $commands;

	/**
	 * Arguments for the command
	 * @var array
	 */
	private $arguments;

	/**
	 * Options for the command
	 * @var array
	 */
	private $options;

	/**
	 * File name that has been executed
	 * @var string
	 */
	private $fileName;

	/**
	 * @return self
	 */
	public function __construct(bool $init = true)
	{
		$this->commands = [];
		$this->arguments = [];
		$this->options = [];

		if ($init)
		{
			$this->init();
		}
	}

	/**
	 * @return array
	 */
	public function getCommands()
	{
		return $this->commands;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getArguments()
	{
		return $this->arguments;
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * Initialize the instance with custom arguments of argv
	 * @param array argument string (0 => filename, 1 => command, rest => arguments/options)
	 * @return self
	 */
	public function init(array $args = null)
	{
		$args = $args ?? $_SERVER['argv'];

		$this->fileName = $args[0];
		$this->name = $args[1];

		unset($args[0], $args[1]);

		foreach ($args as $key => $value)
		{
			if (substr($value, 0, 2) == "--")
			{
				$this->options[] = ltrim($value, '--');
			}
			else
			{
				$this->arguments[] = $value;
			}
		}

		return $this;
	}

	/**
	 * Check if request is run from terminal
	 * @return bool
	 */
	public function isCli()
	{
		return (php_sapi_name() === 'cli' || defined('STDIN'));
	}

	/**
	 * Add command to instance
	 * @param object Hmmm\Component\Terminal\CommandInterface
	 * @return self
	 */
	public function addCommand($command)
	{
		$command = new $command($this->arguments, $this->options);
		$this->commands[$command->getName()] = $command;
		return $this;
	}

	/**
	 * Execute command
	 * @param string name
	 * @return self
	 */
	public function exec(string $name = null)
	{
		$name = $name ?? $this->name;

		if (!isset($this->commands[$name]))
		{
			throw new Exception("Command is invalid or does not exist");
		}

		$this->commands[$name]->exec();

		return $this;
	}

}
