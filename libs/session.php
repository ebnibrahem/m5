<?php namespace M5\Library;

/**
 * set and get session variables
 *
 *  @version 1.0 [first version]
 */
class Session {

	public static function int() {
		session_start();
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * show session var || show all session if-not key seted
	 * @param  string $key session key
	 * @return array
	 */
	public static function get($key=null) {

		if($key)
			return $_SESSION[$key];
		else
			return pa($_SESSION);

	}



	public static function setWink($key,$value){
		Session::set($key,$value);
	}

	/**
	*
	* @param $Delete boolean : set flase in you need to return value e.g.( to check is setted not to print it )
	*/
	public static function getWink($key,$Delete=TRUE){
		if($Delete){
			echo Session::get($key);
			Session::end($key);
		}else{
			return Session::get($key);
		}

	}

	public static function end($key) {
		unset($_SESSION[$key]);
	}

	public static function destory() {
		$_SESSION = [];
		session_destroy();
	}

}