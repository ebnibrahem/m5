<?php
ob_start();
session_start();

#################################
# PHP VERSION
#################################
if(  version_compare(PHP_VERSION, '5.5') < 0 )
	die("<h1 align='center' style='color:red'>THIS SCRIPT NEED PHP VERSION 5.5 OR Higher.<h2 align='center'>Current Version: ".PHP_VERSION."</h2></h1>");

if( ! function_exists("mb_substr") )
	die("<h1 align='center' style='color:red'>THIS SCRIPT NEEDS to active mb_substr Functions .<h2 align='center'> </h1>");

#################################
# General Config
#################################
ini_set('session.cookie_httponly', true);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
date_default_timezone_set("Asia/Riyadh");


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname( dirname(__FILE__)).DS );
define('HOST', trim($_SERVER['HTTP_HOST'],"/") );
define('IP',$_SERVER['REMOTE_ADDR']);

/* Application Directories */
define("C_PATH",    ROOT.'app/_c/');
define("ASSETS_PATH",    ROOT.'assets'.DS);
define("M_PATH",    ROOT.'app/_m/');
define("V_PATH",    ROOT.'app/_v/');
define("LANG_FILE", ROOT.'strings/');

define("_PATH",     ROOT.'assets/');
define("UPLOAD_DIR",ROOT.'upload/');
define("_WID",      V_PATH.'widgets/');


#################################
# Timestamp
################################
define('R_DATE', date("Y-m-d"));
define('R_DATE_LONG', date("Y-m-d H:i:s"));

################################
# Application http links
################################
$_dir = dirname($_SERVER['SCRIPT_NAME']) ;
$link = ($_dir == "/") ? "/" : "/".trim($_dir,"/")."/";

define("URL",       "http://".HOST.$link );
define("ASSETS",    URL.'assets/' );
define('LOGO',      ASSETS.('images/logo.png') );
define('LOADING',   ASSETS.('images/loader.gif') );
define('NO_IMG',    ASSETS.('images/no_image.png') );

###############################
# DEVELOPER MODE
###############################
	define('DEV_MODE', 'on'); // on | no
	define('CACHE_VAR', "?".uniqid()); // "?".uniqid() | no


###############################
	/*Uploads File*/
###############################
	if( !file_exists(UPLOAD_DIR) )
		mkdir(UPLOAD_DIR);

	if( !file_exists(UPLOAD_DIR.'records') )
		mkdir(UPLOAD_DIR.'records');

	if( !file_exists(UPLOAD_DIR.'blogs') )
		mkdir(UPLOAD_DIR.'blogs');

###############################
# REQUIRE FILES
###############################
	require_once ROOT.'vendor/autoload.php';
	require_once ROOT.'libs/functions.php';
	require_once ROOT.'app/config/config_db.php';
	require_once ROOT.'app/config/config_mail.php';
	require_once ROOT.'app/config/config.php';