<?php

namespace Scapegoat;

class NodeTest extends \PHPUnit_Framework_TestCase
{
	public function testInsertAndFlatten()
	{
		$root = new Node(5, SortBy::value());
		$root->insert(7);
		$root->insert(2);
		$root->insert(3);
		$this->assertEquals(array(2,3,5,7), $root->flatten());
	}

	public function testValuesEqual()
	{
		$root = new Node(2, SortBy::value());
		$root->insert(4);
		$root->insert(6);
		$root->insert(4);
		$root->insert(1);
		$root->insert(4);
		$this->assertEquals(array(4,4,4), $root->valuesEqual(4));
		$this->assertEquals(array(6), $root->valuesEqual(6));
		$this->assertEquals(array(), $root->valuesEqual(7));
	}

	public function testValuesLessThan()
	{
		$root = new Node(3, SortBy::value());
		$root->insert(6);
		$root->insert(3);
		$root->insert(5);
		$root->insert(1);
		$root->insert(4);
		$this->assertEquals(array(1,3,3), $root->valuesLessThan(4));
	}

	public function testValuesGreaterThan()
	{
		$root = new Node(3, SortBy::value());
		$root->insert(6);
		$root->insert(3);
		$root->insert(5);
		$root->insert(1);
		$root->insert(4);
		$this->assertEquals(array(4,5,6), $root->valuesGreaterThan(3));
	}

	public function testValuesLessThanOrEqual()
	{
		$root = new Node(3, SortBy::value());
		$root->insert(6);
		$root->insert(3);
		$root->insert(5);
		$root->insert(1);
		$root->insert(4);
		$this->assertEquals(array(1,3,3,4), $root->valuesLessThanOrEqual(4));
	}

	public function testValuesGreaterThanOrEqual()
	{
		$root = new Node(3, SortBy::value());
		$root->insert(6);
		$root->insert(3);
		$root->insert(5);
		$root->insert(1);
		$root->insert(4);
		$this->assertEquals(array(3,4,5,6),
			$root->valuesGreaterThanOrEqual(3));
	}
}
