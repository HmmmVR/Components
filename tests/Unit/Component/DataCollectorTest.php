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
		$this->assertSame($collector->getCollection(), []);
	}

	public function testGetCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", true);
		$this->assertSame($collector->getCollection(), ["test" => true]);
	}

	public function testAddToCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$this->assertSame($collector->getItem("test"), [1,2,3]);
	}

	public function testGetItemFromCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$this->assertSame($collector->getItem("test"), [1,2,3]);
	}

	public function testEditItemFromCollection()
	{
		$collector = new DataCollector();
		$collector->addItem("test", [1,2,3]);
		$collector->editItem("test", [4,5,6]);
		$this->assertSame($collector->getItem("test"), [4,5,6]);
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
		$this->assertSame($collector->getItem(0), "test");
	}

	public function testInitializeAdapter()
	{
		$adapter = new Predefined([]);
		$collector = new DataCollector($adapter);
		$this->assertTrue(($adapter instanceof \Hmmm\Component\DataCollector\Adapter\Predefined));
	}

	public function testPredefinedTypeCheck()
	{
		$adapter = new Predefined(['test' => 'string']);
		$collector = new DataCollector($adapter);
	}

}
