<?php

namespace Hmmm\Component\Terminal;

interface CommandInterface
{

	/**
	 * @param string name
	 * @param array arguments
	 * @param array options
	 * @return self
	 */
	public function __construct(array $arguments, array $options = []);

	/**
	 * @return string name
	 */
	public function getName();

	/**
	 * Execute command
	 * @return void
	 */
	public function exec();

}
