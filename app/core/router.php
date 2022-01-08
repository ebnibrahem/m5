<?php  namespace M5\MVC;

use M5\MVC\Config;

/**
* 	Router of Controllers
* 	prepare all url parts
*
*/
class Router
{
	private static $url;
	private static $SubDirectories;
	private static $Directory;
	private static $controller;
	private static $method;
	private static $params;
	private static $language;
	private static $error;


	/**
	 * Parsing url.
	 *
	 */
	public function __construct($url)
	{
		/* Specified URL */
		self::$url = !$url ? "/" : $url ;

		$url = trim($url, "/");
		$url = rtrim($url, "/");
		$url = rtrim($url, "'");
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url_parts = (array) explode("/", $url);

		self::$SubDirectories =  Config::get("directory");

		/* Specified languages */
		if( in_array(strtolower($url_parts[0]), Config::get("languages")) ){
			$lang_file = strtolower($url_parts[0]);
			$lang_file_created = ( file_exists(LANG_FILE.$lang_file.'.php') ) ? "1" : "0" ;

			array_shift($url_parts);
		}

		self::$language = !$lang_file_created ? Config::get("default_language") : $lang_file;

		/* Specified Controller inside child Directory  */
		$Directory  = Config::get("directory")[0]."/";
		if( in_array(strtolower($url_parts[0]), Config::get("directory")) ){
			$Directory = $url_parts[0];
			array_shift($url_parts);
		}
		self::$Directory = $Directory;

		/* Specified Controller */
		$controller  = $url_parts[0];
		if(!$url_parts[0]){
			$controller = Config::get("default_controller");
		}else{
			array_shift($url_parts);
		}
		self::$controller = ucfirst($controller);


		/* Specified Methods */
		$method = !$url_parts[0] ? Config::get("default_method") :$url_parts[0];
		self::$method = strtolower($method);
		// pa($url_parts, '0', '#299'); 

		$url_parts[0] ? array_shift($url_parts) : '' ;
		/* Specified parameters */
		$params =  $url_parts;
		// pa($params, '0', '#299'); 

		Self::$params = $params;

	}


	public static function getUrl(){
		return self::$url;
	}

	public static function GetSubDirectories(){
		return self::$SubDirectories;
	}

	public static function getDirectory(){
		return self::$Directory;
	}

	public static function getController($with_dir=false){
		$if_contoroller_inside_dir = (self::$Directory == "/") ? "" : self::$Directory."/";
		return $with_dir ? $if_contoroller_inside_dir.self::$controller :self::$controller;
	}

	public static function getMethod(){
		return self::$method;
	}

	public static function getParams(){
		return self::$params;
	}

	public static function getLanguage(){
		return self::$language;
	}

	/**
	 * [redirect description]
	 *
	 * @param  string $path page url.
	 * @return response
	 */
	public static function redirect($path=null,$die=null){

		if(!$path){
			header('location:'.Config::get('site'));
		}else{
			header('location:'.$path);
		}

		if($die){
			die();
		}

	}


}
