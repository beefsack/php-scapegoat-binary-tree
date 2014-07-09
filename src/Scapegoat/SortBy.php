<?php

namespace Scapegoat;

class SortBy
{
	public static function value()
	{
		return function($v) {
			return $v;
		};
	}

	public static function method($method)
	{
		return function($v) use ($method) {
			return $v->$method();
		};
	}

	public static function arrayOffset($offset)
	{
		return function($v) use ($offset) {
			return $v[$offset];
		};
	}

	public static function member($member)
	{
		return function($v) use ($member) {
			return $v->$member;
		};
	}
}
