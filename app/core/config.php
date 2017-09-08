<?php namespace M5\MVC;

	/**
	* Configuration Settings
	* 	
	*/

	class Config
	{

		protected static $info;

		public static function set($key,$value)
		{
			return self::$info[$key] = $value;
		}

		public static function get($key)
		{
			return isset(self::$info[$key]) ? self::$info[$key] : null;
		}
		

	}