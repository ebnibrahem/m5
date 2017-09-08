<?php namespace M5\Models;

use M5\MVC\Model as BaseModel;
use M5\Library\Lens;

/**
*
*/
class Files_model
{

	function __construct()
	{

	}

	/**
	 * view all files 
	 * @param  array $args one | more path
	 * @return []row by files
	 */
	function _all(array $args)
	{
		if( count($args) < 1 ) pre(__METHOD__ .': <u>meet all arguments</u>');
		// extract($args);
		pa($args);

		foreach ($args as $key => $PATH) {
			$DIR = DIR;
			$http_path_format = site.str_replace($DIR, "", $PATH);
			$r[] = lens::cornea($PATH,$http_path_format);
		}

		return $r;
		
	}

}