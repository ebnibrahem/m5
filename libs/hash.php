<?php namespace M5\Library;

use M5\MVC\Config;

/**
 * put some salt to meet
 * 
 */
class Hash {

	public static function MD5($password) {
		$algo = "md5";
		$default_salt_key =  !Config::get("salt") ? 'mic87' : Config::get("salt");

		$c = hash_init($algo, HASH_HMAC, $default_salt_key);
		hash_update($c, $password);
		return hash_final($c);
	}
}
