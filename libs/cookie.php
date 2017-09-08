<?php namespace M5\Library;

/**
 * set and get Cookie variables
 *
 *  @version 1.0 [first version]
 */

class Cookie {

	public static function Set($key, $value) {
		setcookie($key, $value, time() + (86400 * 30), "/");
	}

	public static function Get($key='') {
		if($key)
			return $_COOKIE[$key];

		return pa($_COOKIE);
	}

	public static function End($key) {
		unset($_COOKIE[$key]);
	}

}
