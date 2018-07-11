<?php

use \PHPUnit\Framework\TestCase;

use \Hmmm\Component\Terminal\Terminal;
use \Hmmm\Component\Terminal\CommandInterface;

class __Command implements \Hmmm\Component\Terminal\CommandInterface
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

class TerminalTest extends TestCase
{

	public function testAddCommand()
	{
		$terminal = new Terminal();
		$terminal->addCommand(__Command::class);
		$final = $terminal->getCommands();

		$this->assertTrue($final["TestCommand"] instanceof __Command);
	}

	public function testExecWithArguments()
	{
		$terminal = new Terminal(false);
		$terminal->init(["x.php","TestCommand","test"]);
		$terminal->addCommand(__Command::class);

		ob_start();
		$terminal->exec();
		$final = ob_get_contents();
		ob_end_clean();

		$this->assertSame(trim($final), "test");
	}

	public function testExecWithOption()
	{
		$terminal = new Terminal(false);
		$terminal->init(["x.php", "TestCommand", "--test"]);
		$terminal->addCommand(__Command::class);

		ob_start();
		$terminal->exec();
		$final = ob_get_contents();
		ob_end_clean();

		$this->assertSame(trim($final), "test");
	}

	public function testExecWithArgumentsAndOptions()
	{
		$terminal = new Terminal(false);
		$terminal->init(["x.php", "TestCommand", "arg", "--option"]);
		$terminal->addCommand(__Command::class);

		ob_start();
		$terminal->exec();
		$final = ob_get_contents();
		ob_end_clean();

		$this->assertSame(trim($final), "argoption");
	}

}
