<?php namespace M5\Library;

/**
* Navigation links ? bread | breadcrumbs
*/
class Bread
{
	static private
	$show;

	static function create($args,$home='admin/cp')
	{
		extract($args);
		$dir = TEXT_DIRECTION_END;

		$home = '<li><a href="'.url($home).'"><i class="fa fa-home"></i>'.str('Home').'</a></li>';
		if($args){
			foreach ($args as $text => $src) {

				$url = ($src == "#" || $src == "")
				? '<li><i class="fa fa-angle-double-'.$dir.'"></i>'.$text.'</li>'
				: '<li><a href="'.url($src).'"><i class="fa fa-angle-'.$dir.'"></i>'.$text.'</a></li>';

				$bread .=$url;
			}
			$bread = '<ul id="bread">'.$home.$bread.'</ul>';
		}

		self::$show = $bread;

		return $bread;
	}
}
