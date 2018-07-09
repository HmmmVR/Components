<?php

use \PHPUnit\Framework\TestCase;

use \Hmmm\Component\Pattern\Singleton;
use \Hmmm\Component\Pattern\Pipeline;

class PatternTest extends TestCase
{

	/**
	 * @expectedException Error
	 */
	public function testSingleton()
	{
		$a = new Singleton();
	}

	public function testPipeline()
	{
		$data = 0;
		$pipeline = new Pipeline();
		
		$pipeline->addPipe(function ($data){
			return $data += 1;
		});

		$pipeline->addPipe(function ($data){
			return $data += 1;
		});

		$pipeline->addPipe(function ($data){
			return $data += 1;
		});

		$pipeline->exec($data);
		$final = $pipeline->getResult();

		$this->assertSame($final, 3);
	}

}
