<?php

namespace Scapegoat;

class SortBy
{
	public function value()
	{
		return function($v) {
			return $v;
		};
	}

	public function method($method)
	{
		return function($v) use ($method) {
			return $v->$method();
		};
	}

	public function arrayOffset($offset)
	{
		return function($v) use ($offset) {
			return $v[$offset];
		};
	}

	public function member($member)
	{
		return function($v) use ($member) {
			return $v->$member;
		};
	}
}
