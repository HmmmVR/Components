<?php

use \PHPUnit\Framework\TestCase;
use \Hmmm\Component\DataCollector\DataCollector;
use \Hmmm\Component\DataCollector\AdapterInterface;
use \Hmmm\Component\DataCollector\Adapter\Predefined;

class DataCollectorTest extends TestCase
{
	
	public function testCreateCollection()
	{
		$collector = new DataCollector();
		$final = $collector->getCollection();

		$this->assertSame($final, []);
	}

	public function testGetCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", true);
		$final = $collector->getCollection();

		$this->assertSame($final, ["test" => true]);
	}

	public function testAddToCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$final = $collector->getItem("test");

		$this->assertSame($final, [1,2,3]);
	}

	public function testGetItemFromCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$final = $collector->getItem("test");

		$this->assertSame($final, [1,2,3]);
	}

	public function testEditItemFromCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$collector->editItem("test", [4,5,6]);
		$final = $collector->getItem("test");

		$this->assertSame($final, [4,5,6]);
	}

	/**
	 * @expectedException Exception
	 */
	public function testRemoveItemFromCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$collector->removeItem("test");
		$collector->getItem("test");
	}

	public function testAppendItemToCollection()
	{
		$collector = new DataCollector();
		$collector->appendItem("test");
		$final = $collector->getItem(0);

		$this->assertSame($final, "test");
	}

	public function testInitializeAdapter()
	{
		$adapter = new Predefined([]);
		$collector = new DataCollector($adapter);
		$this->assertTrue(($adapter instanceof \Hmmm\Component\DataCollector\Adapter\Predefined));
	}

	public function testPredefinedTypeCheck()
	{
		$adapter = new Predefined(["test" => "string"]);
		$collector = new DataCollector($adapter);
		$collector->addItem("test", "test data");
		$final = $collector->getItem("test");

		$this->assertSame($final, "test data");
	}

	/**
	 * @expectedException Exception
	 */
	public function testPredefinedTypeCheckWrong()
	{
		$adapter = new Predefined(["test" => "string"]);
		$collector = new DataCollector($adapter);
		$collector->addItem("test", 1);
	}

	public function testPredefinedEdit()
	{
		$adapter = new Predefined(["test" => "int"]);
		$collector = new DataCollector($adapter);
		$collector->addItem("test", 1);
		$collector->editItem("test", 2);
		$final = $collector->getItem("test");

		$this->assertSame($final, 2);
	}

	public function testPredefinedList()
	{
		$adapter = new Predefined("string");
		$collector = new DataCollector($adapter);
		$collector->appendItem("test data");
		$final = $collector->getItem(0);

		$this->assertSame($final, "test data");
	}

	public function testCustomType()
	{
		$adapter = new Predefined(["test" => "testType"]);
		$adapter->addType("testType", function ($v) {
			return $v === "test";
		});
		$collector = new DataCollector($adapter);
		$collector->addItem("test", "test");
		$final = $collector->getItem("test");
		
		$this->assertSame($final, "test");
	}

	/**
	 * @expectedException Exception
	 */
	public function testCustomTypeFail()
	{
		$adapter = new Predefined(["test" => "testType"]);
		$adapter->addType("testType", function ($v) {
			return $v === "test";
		});
		$collector = new DataCollector($adapter);
		$collector->addItem("test", "something different");
		$final = $collector->getItem("test");
	}

}
