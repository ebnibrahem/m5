<?php

/*
*  Debug print and pre &&/ die
*
*/
function pa($arr='',$stop='',$bg_clr='rgba(225,255,255,0.8)')
{
	echo '<pre class="pa" dir="ltr"
	style="color:#272727;background-color:'.$bg_clr.';z-index:9999999;position:relative;width:100%";text-align:left>';
	!$arr ? print_r($_POST) : print_r($arr);
	echo '</pre>';

	if($stop)
		die();
}

function vd($text){
	echo '<pre class="pa" dir="ltr" align="left">';
	var_dump($text);
	echo '</pre>';
}

function ve($text){
	echo '<pre class="pa" dir="ltr" align="left">';
	var_export($text);
	echo '</pre>';
}


/*
* pre
 */
function pre($text,$align='left',$dir='ltr',$clr='#000'){
	echo '<pre style ="color:'.$clr.';text-align:'.$align.';direction:'.$dir.'">'.$text.'</pre>';
}


/**
 * Call global key
 *
 */

function str($key='',$charset=''){
	$key = strtolower($key);

	echo $charset ? '<meta charset="'.$charset.'">' : '' ;

	if(!$key)
		pa( $GLOBALS );

	if( array_key_exists($key, $GLOBALS) === TRUE){
		return $GLOBALS[$key];
	}
	else{
		return str_replace("_"," ",$key."");
	}
}

/**
 * Call $GLOBALS key multi | individual.
 *
 */
function s($keys,$separator="",$replace=null){
	$separator = !$separator ? " " : $separator;

	if( is_array($keys) === TRUE ){

		foreach ($keys as $key => $value) {
			$string = strtolower($value);

			$text .= (array_key_exists($string, $GLOBALS) === TRUE) ? $GLOBALS[$string].$separator : str_replace("_"," ",$string."").$separator;
		}

		$text =  rtrim($text,$separator);

		return $text;
	}

	return
	$ret = (array_key_exists($keys, $GLOBALS) === TRUE) ? $GLOBALS[$keys].$separator : str_replace("_"," ",$keys."").$separator;
}


function string($key,$charset=''){
	return str($key,$charset='');
}


/**
* add toekn to csrf
*
*/

function csrf_fields()
{
	$s = Hash2(rand(4646,797987));
	$_SESSION['csrf_fields'] = $s;
	echo '<input type="hidden" name="_token" value="'.$s.'">';
}

/**
 * $xhr Boolean 0: if you need to check func return values.
 *
 * @version 1.1 [<check func return values>]
 * @return mixed
 */
function captcha_ck($captcha='captcha',$msg='captcha not valid!', $xhr=true)
{
	// pre($_SESSION['captcha'] ." ".$_POST[$captcha] );

	if( $_SESSION['captcha'] != $_POST[$captcha])
	{
		if($xhr){
			die( msg($msg,'alert alert-warning _caps'));
		}else{
			return null;
		}

	}else{
		return 1;
	}
}


/**
* set value in html title tag
*
*/
function title($title=''){
	return '<title>'.$title.'</title>';
}


/*
* genrate randoum 32bit string;
*
*/
function Hash2($string='')
{
	$algo = "md5";
	$salt = "mic87";

	$c = hash_init($algo, HASH_HMAC, $salt);
	hash_update($c, $string);

	return hash_final($c);
}

/**
* @flag  boolean multi-langs
*
* return absolute url
*/
function url($path='',$flag=null){
	return
	!$flag ?
	strtolower( rtrim(M5\MVC\Config::get('site'),"/")."/".$path):
	strtolower( rtrim(M5\MVC\Config::get('site'),"/") ."/".$path);

}

/**
* return absolute path off assets
*
* v1.1 optional path
*/
function assets($path=''){
	return URL."assets/".$path;
}

/*
* print text in div with class and dir
*
*/
function msg($text,$class='alert alert-info',$dir='rtl'){
	return '<div dir="' . $dir . '" class="' . $class. '">' .$text.'</div>' ;
}


/**
* pure class model name without namespace path && _PRE
*
*/
function pure_class($namespace,$_PRE='_model')
{
	$c = explode("\\", $namespace);
	$c = strtolower( end($c) );
	$c = str_replace($_PRE, "", $c);

	return $c;
}


/**
* retrun absolute path of view folder.
*/
function view($path=''){
	return V_PATH.$path;
}


/* show object in console*/
function console(array $arr,$notes=''){
	$obj = (object) $arr;

	$json =  @json_encode($obj);
	print "<script>console.warn('$notes');</script>";
	print "<script>console.log($json);</script>";

	echo '</script>' ;
}

/**
	 * Convert array to json object.
	 * @param  array $arr.
	 * @return json
	 */
function p($arr='',$var='msg'){

	$arr = (object) $arr;
	echo json_encode($arr);
}


/**
 * print javascript code | jquery.
 *
 * @param  string $jsCode
 * @param  boolean $jquery
 * @return void
 */
function script($jsCode,$jquery=''){
	if($jquery){
		print "<script>$(document).ready(function($) {".$jsCode."});</script>";
	}else{
		print "<script>'$jsCode'</script>";
	}
}

/**
 * put text between div tags.
 *
 * @var string $text
 * @return html
 */
function div($text,$class=''){
	echo "<div class='$class'>".$text."</div>";
}


function calendar($pre='cal_',$flage=false)
{
	$arr = $flage ? '[]' : '';
	echo "<div class=row>";

	echo "<div class=col-md-4>";

	echo '<select class="form-control" name= "'.$pre.'_h'.$arr.'" >';
	echo '<option value="0">--سنة--</option>';
	for($i=1300; $i<=1499; $i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
	echo '</div>';

	echo "<div class=col-md-4>";

	echo '<select class="form-control" name= "'.$pre.'_m'.$arr.'" >';
	echo '<option value="0">--شهر--</option>';
	for($i=1; $i<=12; $i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
	echo '</div>';

	echo "<div class=col-md-4>";
	echo '<select class="form-control" name= "'.$pre.'_d'.$arr.'" >';
	echo '<option value="0">--يوم--</option>';
	for($i=1; $i<=30; $i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
	echo '</div>';
	echo '</div>';
}

/**
*	Clear html <br>  When you used nl2br or str with <br>
*	@version 1
*/
function textarea($text,$flag=null){
	return trim( str_replace(["<br />","<br/>","<br>"],["\n","\n","\n"],$text) );
}

/**
*	Clear html <br>  When you used nl2br or str with <br>
*	@version 1
*/
function get_uploads($folder_name,$flag=null,$printPath=null){

	if(!file_exists($folder_name))
		return( pre (__FUNCTION__ ."() >> ".$folder_name." Does not exists!") );

	$uploads = \M5\Library\Lens::cornea($folder_name,URL.$folder_name."/");

	$printPath ? pre($folder_name) : '' ;

	// pa (  $uploads);

	return	 isset($flag) ? $uploads[$flag] : $uploads;
}

/* Tinymce strip script tag*/

function content($text){
	return  str_replace(
		[ "[/script]", "[script]", "[script " ], ['</script>','[script]', '<script '], $text
		) ;
}


/**
 * src >> path >> retrun src+watermark
 * @param  array  $args scr
 * @return watermark image in the same path
 */
function watermark(array $args){

	extract($args);
	$src = $args['src'];
	$st = $args['st'];


	$logo =  !$args['logo'] ? LOGO : $args['logo'];
	$target = $src;

	$target_name = basename($src);

	/*dont watring logo*/
	if( basename($target) == basename($logo) ){
		return LOGO;
	}

	/*Our watermark  [ must .png Format ]  */
	$watermark = imagecreatefrompng($logo);
	imagealphablending($watermark, false);
	imagesavealpha($watermark, true);


	$watermark_w = imagesx($watermark);
	$watermark_h = imagesy($watermark);



	/*Target image Format */
	$img_format = strtolower( end( explode(".",$target_name) ) );

	/* 1. JPG */
	if($img_format == "jpeg" || $img_format == "jpg"){
		$image = imagecreatefromjpeg($target);
		$img_format = "jpeg";
	}

	/* 2. PNG */
	if($img_format == "png")
		$image = imagecreatefrompng($target);

	/* 3. GIF */
    // if($img_format == "gif")
    // $image = imagecreatefromgif($target);

    // die( pre( $img_format));

	imagealphablending($image, false);
	imagesavealpha($image, true);


	$image_w = imagesx($image);
	$image_h = imagesy($image);


	/*Positioning On Right-Bottom-corner */
	$dst_x =  $image_w - $watermark_w;
	$dst_y =  $image_h -$watermark_h;

	/* optimize faded background (images without background)*/
	//???????????

	/*Put logo on images */
	imagecopymerge($image, $watermark, $dst_x, $dst_y, 0, 0, $watermark_w, $image_h,50);


	// echo "$img_format";
	// pa($args,1);

	// Output and free memory
	header("Content-type: image/$img_format");

	$save_as = $target;

	imagejpeg($image,$save_as,$image_w);
	imagedestroy($image);

	return $src;

}

/**
 * convert http url to file system format
 * @param  [type] $http_url
 * @return path.
 */
function dir_format($http_url){
	$dir = ROOT;
	$site = site;

	$path =  str_replace("$site", "", $http_url);

	if( file_exists($path) === TRUE)
		return $path;
	else
		return null;

}

/**
 * convert file system to http url format
 * @param  [type] $http_url
 * @return url
 */
function http_format($path){
	$dir = ROOT;
	$site = site;

	$url =  str_replace($dir, "", $path);
	return $url;
}


/**
 * get the main color of an image
 *
 * @param url path
 * @return String color;
 */
function getImageColor($path){
	$img_format = strtolower( end( explode(".",$path) ) );

	$image= ($img_format == "png") ? imagecreatefrompng( $path ): imagecreatefromjpeg($path);

	$thumb=imagecreatetruecolor(1,1); imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
	$mainColor=strtoupper(dechex(imagecolorat($thumb,0,0)));
	return "#".$mainColor;
}


function detectColors($image, $num, $level = 5) {
	$level = (int)$level;
	$palette = array();
	$size = getimagesize($image);
	if(!$size) {
		return FALSE;
	}
	switch($size['mime']) {
		case 'image/jpeg':
		$img = imagecreatefromjpeg($image);
		break;
		case 'image/png':
		$img = imagecreatefrompng($image);
		break;
		case 'image/gif':
		$img = imagecreatefromgif($image);
		break;
		default:
		return FALSE;
	}
	if(!$img) {
		return FALSE;
	}
	for($i = 0; $i < $size[0]; $i += $level) {
		for($j = 0; $j < $size[1]; $j += $level) {
			$thisColor = imagecolorat($img, $i, $j);
			$rgb = imagecolorsforindex($img, $thisColor);
			$color = sprintf('%02X%02X%02X', (round(round(($rgb['red'] / 0x33)) * 0x33)), round(round(($rgb['green'] / 0x33)) * 0x33), round(round(($rgb['blue'] / 0x33)) * 0x33));
			$palette[$color] = isset($palette[$color]) ? ++$palette[$color] : 1;
		}
	}
	arsort($palette);
	return array_slice(array_keys($palette), 0, $num);
}


/**
 * world
 * @return [type] [description]
 */
function world()
{
	return
	[
	"Afghanistan",
	"Albania",
	"Algeria",
	"American  Samoa",
	"Andorra",
	"Angola",
	"Anguilla",
	"Antigua  and Barbuda",
	"Argentina",
	"Armenia",
	"Aruba",
	"Australia",
	"Austria",
	"Azerbaijan",
	"Bahamas , The",
	"Bahrain",
	"Bangladesh",
	"Barbados",
	"Belarus",
	"Belgium",
	"Belize",
	"Benin",
	"Bermuda",
	"Bhutan",
	"Bolivia",
	"Bosnia  and Herzegovina",
	"Botswana",
	"Brazil",
	"British  Virgin Islands",
	"Brunei",
	"Bulgaria",
	"Burkina  Faso",
	"Burundi",
	"Cambodia",
	"Cameroon",
	"Canada",
	"Cape  Verde",
	"Cayman  Islands",
	"Central  African Republic",
	"Chad",
	"Chile",
	"China",
	"Christmas  Island",
	"Cocos  (Keeling) Islands",
	"Colombia",
	"Comoros",
	"Congo",
	"Cook  Islands",
	"Costa  Rica",
	"Côte  d'Ivoire",
	"Croatia",
	"Cuba",
	"Curaçao",
	"Cyprus",
	"Czech  Republic",
	"Democratic  Republic of Congo",
	"Denmark",
	"Djibouti",
	"Dominica",
	"Dominican  Republic",
	"East  Timor",
	"Ecuador",
	"Egypt",
	"El  Salvador",
	"Equatorial  Guinea",
	"Eritrea",
	"Estonia",
	"Ethiopia",
	"Falkland  Islands (Islas Malvinas)",
	"Faroe  Islands",
	"Federated  States of Micronesia",
	"Fiji",
	"Finland",
	"France",
	"French  Guiana",
	"French  Polynesia",
	"Gabon",
	"Gambia",
	"Georgia",
	"Germany",
	"Ghana",
	"Gibraltar",
	"Greece",
	"Greenland",
	"Grenada",
	"Guadeloupe  (Fr.)",
	"Guam",
	"Guatemala",
	"Guernsey",
	"Guinea",
	"Guinea -Bissau",
	"Guyana",
	"Haiti",
	"Honduras",
	"Hong  Kong",
	"Hungary",
	"Iceland",
	"India",
	"Indonesia",
	"Iran",
	"Iraq",
	"Ireland",
	"Isle  of Man",
	"Israel",
	"Italy",
	"Jamaica",
	"Japan",
	"Jersey",
	"Jordan",
	"Kazakhstan",
	"Kenya",
	"Kiribati",
	"Kosovo",
	"Kuwait",
	"Kyrgyzstan",
	"Laos",
	"Latvia",
	"Lebanon",
	"Lesotho",
	"Liberia",
	"Libya",
	"Liechtenstein",
	"Lithuania",
	"Luxembourg",
	"Macau",
	"Macedonia",
	"Madagascar",
	"Malawi",
	"Malaysia",
	"Maldives",
	"Mali",
	"Malta",
	"Marshall  Islands",
	"Martinique  (Fr.)",
	"Mauritania",
	"Mauritius",
	"Mexico",
	"Moldova",
	"Monaco",
	"Mongolia",
	"Montenegro",
	"Montserrat",
	"Morocco",
	"Mozambique",
	"Myanmar",
	"Namibia",
	"Nauru",
	"Nepal",
	"Netherlands",
	"Netherlands  Antilles",
	"New  Caledonia",
	"New  Zealand",
	"Nicaragua",
	"Niger",
	"Nigeria",
	"Niue",
	"Norfolk  Island",
	"North  Korea",
	"Northern  Mariana Islands",
	"Norway",
	"Oman",
	"Pakistan",
	"Palau",
	"Palestinian  Territories",
	"Panama",
	"Papua  New Guinea",
	"Paraguay",
	"Peru",
	"Philippines",
	"Pitcairn  Islands",
	"Poland",
	"Portugal",
	"Puerto  Rico",
	"Qatar",
	"Reunion  (Fr.)",
	"Romania",
	"Russia",
	"Rwanda",
	"Saint  Helena",
	"Saint  Kitts and Nevis",
	"Saint  Lucia",
	"Saint  Vincent and the Grenadines",
	"Samoa",
	"San  Marino",
	"Sao  Tome and Principe",
	"Saudi  Arabia",
	"Senegal",
	"Serbia",
	"Seychelles",
	"Sierra  Leone",
	"Singapore",
	"Sint  Maarten",
	"Slovakia",
	"Slovenia",
	"Solomon  Islands",
	"Somalia",
	"South  Africa",
	"South  Georgia and the South Sandwich Islands",
	"South  Korea",
	"South  Sudan",
	"Spain",
	"Sri  Lanka",
	"Sudan",
	"Suriname",
	"Svalbard",
	"Swaziland",
	"Sweden",
	"Switzerland",
	"Syria",
	"Taiwan",
	"Tajikistan",
	"Tanzania",
	"Thailand",
	"Togo",
	"Tokelau",
	"Tonga",
	"Trinidad  and Tobago",
	"Tunisia",
	"Turkey",
	"Turkmenistan",
	"Turks  and Caicos Islands",
	"Tuvalu",
	"Uganda",
	"Ukraine",
	"United  Arab Emirates",
	"United  Kingdom",
	"Uruguay",
	"USA",
	"Uzbekistan",
	"Vanuatu",
	"Vatican  City",
	"Venezuela",
	"Vietnam",
	"Virgin  Islands",
	"Western  Sahara",
	"Yemen",
	"Zambia",
	"Zimbabwe"
	];
}

/**
 * add language path to url.
 *
 * @return string
 */
function lang($lang=''){
	$url = "http://".$_SERVER['HTTP_HOST']."/";

	$dir = trim(dirname($_SERVER['SCRIPT_NAME']),"/");

	$uri = ltrim( $_SERVER['REQUEST_URI'],"/");
	$uri = explode($dir,$uri);

	// pa($uri);

	$uri = $lang ? $dir."/".$lang."/".implode("/",$uri) : $dir."/".implode("/",$uri);
	return $url.$uri;
}

/**
 * Remove space from css file and/or save main file.
 *
 * @return plaintext
 */
function minimizing($files_name=[],$flag=null,$save_main='__'){


	if(is_array($files_name) === TRUE){
		$files = $files_name;
	}else{
		$files[] = $files_name;
	}

	if(!$files) return null;

	foreach ($files as $key => $f_name) {
		$_cssf =  ASSETS_PATH.("css".DS.$f_name.'.css');
		if(file_exists($_cssf)){

			$main_css = trim(file_get_contents($_cssf));

			/*remove command*/
			$mini_css = preg_replace('/(\/\*).+?(\*\/)/', "", $main_css );

			/*remove double white space */
			$mini_css = preg_replace('/\s\s/', "", $mini_css );

			/*remove new line \n */
			$mini_css = preg_replace('/[\n]/', "", $mini_css );

			/* if main file not exists Then minimizing*/
			$name_of_main =  ASSETS_PATH.("css".DS.$f_name.$save_main.'.css');
			if( !file_exists($name_of_main) ){

				if($save_main){
					$create_main = file_put_contents($name_of_main,$main_css);
				}

				$name_of_mini =  ASSETS_PATH.("css".DS.$f_name.'.css');
				$create_mini = file_put_contents($name_of_mini,$mini_css);
			}

			$flag ? pre("minimizing : ".$_cssf) : '';
		}
	}

	return true;

}

/**
* date_format()
* @type mixed
*/
function date_echo($date_var,$to){

	echo date( $to,  strtotime($date_var));
}
