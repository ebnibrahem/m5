<?php namespace M5\Library;

/**
* General Tools
* 
*/
class Tools {

	public static function getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public static function Gravatar($email, $size = '200',$default=LOGO) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5(strtolower(trim($email)));
		$url .='?s=' . $size.'&d=mm';
		return urldecode($url);
	}

	/**
	 * retrun geo information
	 */

	static function Geo($ip=''){
		if(!$ip){
			$ip = $_SERVER['REMOTE_ADDR'];
		}   
		if($_SERVER['HTTP_HOST'] == "localhost"){
			return ["geoplugin_countryName"=>"localhost"];
		}else{
			$ip_info = unserialize( @file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip") );
		// pen::print_array($ip_info);
			return $ip_info;
		}
	}

}

