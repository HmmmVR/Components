<?php

use \PHPUnit\Framework\TestCase;

use \Hmmm\Component\Terminal\Terminal;
use \Hmmm\Component\Terminal\CommandInterface;
use \TestData\__Command;

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
