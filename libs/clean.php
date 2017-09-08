<?php namespace M5\Library;

/**
 * Cleaning all dust-out in text
 *
 * @version 1.0 [first definition]
 */

class Clean
{
	
	public static function int($string) {
		return abs(intval($string));
	}

	public static function htmlTag($string) {
		$e = trim($string, " ");
		$e = addslashes($e);
		$e = strip_tags($e);

		return $e;
	}

	public static function sqlInjection($string) {
		$e = trim($string, " ");

		$e = addslashes($e);
		$e = str_replace("'", "", $e);
		$e = str_replace("\\", "", $e);
		$e = strip_tags($e);
		$e = trim($e, " ");

		return $e;
	}

	public static function whiltSpace($string) {
		$e = trim($string, " ");
		return $e;
	}

	public static function Raffish($comment, $blackListWords, $replacementer = '***') {
		$wordMenu = explode(" ", $blackListWords);

		return str_replace($wordMenu, $replacementer, $comment);
	}

	static function blind($text){
		$e = self::whiltSpace($text);
		$e = addslashes($e);
		$e = rtrim($e, " ");
		$e = ltrim($e, " ");
		$e = trim($e, "'");

		return $e;
	}

	static function xss($text,$all=FALSE){

		$e = str_replace("script","",$text);
		$e = str_replace("&lt;script&gt;","",$e);

		return $e;

	}

	static function escape($text){
		return mysqli_escape_string($tex);
	}

}