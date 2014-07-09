<?php

namespace Scapegoat;

class Node
{
	private $value;
	private $left;
	private $right;
	private $sortByFunc;

	public function __construct($value, $sortByFunc) {
		if (!is_callable($sortByFunc)) {
			throw new \InvalidArgumentException('sortBy must be callable');
		}
		$this->value = $value;
		$this->sortByFunc = $sortByFunc;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getLeft()
	{
		return $this->left;
	}

	public function getRight()
	{
		return $this->right;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setLeft(Node $node)
	{
		$this->left = $node;
	}

	public function setRight(Node $node)
	{
		$this->right = $node;
	}

	public function setLeftValue($value)
	{
		$this->setLeft(new Node($value, $this->sortByFunc));
	}

	public function setRightValue($value)
	{
		$this->setRight(new Node($value, $this->sortByFunc));
	}

	public function removeLeft()
	{
		$node = $this->left;
		$this->left = null;
		return $node;
	}

	public function removeRight()
	{
		$node = $this->right;
		$this->right = null;
		return $node;
	}

	public function insert($value)
	{
		if ($this->sortBy($value) < $this->sortBy($this->value)) {
			if (isset($this->left)) {
				$this->left->insert($value);
			} else {
				$this->setLeftValue($value);
			}
		} else {
			if (isset($this->right)) {
				$this->right->insert($value);
			} else {
				$this->setRightValue($value);
			}
		}
	}

	public function flatten()
	{
		$left = array();
		if (isset($this->left)) {
			$left = $this->left->flatten();
		}
		$right = array();
		if (isset($this->right)) {
			$right = $this->right->flatten();
		}
		return array_merge($left, array($this->value), $right);
	}

	public function valuesEqual($value)
	{
		$by = $this->sortBy($value);
		$nodeBy = $this->sortBy($this->value);
		$matching = array();
		if ($by <= $nodeBy) {
			if (isset($this->left)) {
				$matching = array_merge($matching, $this->left->valuesEqual(
					$value));
			}
		}
		if ($by == $nodeBy) {
			$matching[] = $this->value;
		}
		if ($by >= $nodeBy) {
			if (isset($this->right)) {
				$matching = array_merge($matching, $this->right->valuesEqual(
					$value));
			}
		}
		return $matching;
	}

	public function valuesLessThan($value)
	{
		$by = $this->sortBy($value);
		$nodeBy = $this->sortBy($this->value);
		$lessThan = array();
		if ($nodeBy < $by) {
			if (isset($this->left)) {
				$lessThan = $this->left->flatten();
			}
			$lessThan[] = $this->value;
			if (isset($this->right)) {
				$lessThan = array_merge($lessThan,
					$this->right->valuesLessThan($value));
			}
		} elseif (isset($this->left)) {
			$lessThan = $this->left->valuesLessThan($value);
		}
		return $lessThan;
	}

	public function valuesGreaterThan($value)
	{
		$by = $this->sortBy($value);
		$nodeBy = $this->sortBy($this->value);
		$greaterThan = array();
		if ($nodeBy > $by) {
			$greaterThan[] = $this->value;
			if (isset($this->right)) {
				$greaterThan = $this->right->flatten();
			}
			if (isset($this->left)) {
				$greaterThan = array_merge(
					$this->left->valuesGreaterThan($value), $greaterThan);
			}
		} elseif (isset($this->right)) {
			$greaterThan = $this->right->valuesGreaterThan($value);
		}
		return $greaterThan;
	}

	public function valuesLessThanOrEqual($value)
	{
		$by = $this->sortBy($value);
		$nodeBy = $this->sortBy($this->value);
		$lessThan = array();
		if ($nodeBy <= $by) {
			if (isset($this->left)) {
				$lessThan = $this->left->flatten();
			}
			$lessThan[] = $this->value;
			if (isset($this->right)) {
				$lessThan = array_merge($lessThan,
					$this->right->valuesLessThanOrEqual($value));
			}
		} elseif (isset($this->left)) {
			$lessThan = $this->left->valuesLessThanOrEqual($value);
		}
		return $lessThan;
	}

	public function valuesGreaterThanOrEqual($value)
	{
		$by = $this->sortBy($value);
		$nodeBy = $this->sortBy($this->value);
		$greaterThan = array();
		if ($nodeBy >= $by) {
			$greaterThan[] = $this->value;
			if (isset($this->right)) {
				$greaterThan = $this->right->flatten();
			}
			if (isset($this->left)) {
				$greaterThan = array_merge(
					$this->left->valuesGreaterThanOrEqual($value),
					$greaterThan);
			}
		} elseif (isset($this->right)) {
			$greaterThan = $this->right->valuesGreaterThanOrEqual($value);
		}
		return $greaterThan;
	}

	public function height() {
		$height = 0;
		if (isset($this->left)) {
			$height = $this->left->height();
		}
		if (isset($this->right)) {
			$height = max($height, $this->right->height());
		}
		return $height + 1;
	}

	private function sortBy($v)
	{
		$f = $this->sortByFunc;
		return $f($v);
	}
}
