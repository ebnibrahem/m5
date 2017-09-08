<?php
/* Application basic information */

use M5\MVC\Config;
use M5\Library\Session;

/* website and hosting */
Config::set("site","http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/' );

/* Languages supported */
Config::set("languages",['ar','en']);

/* 404 error */
Config::set("default_404_class","blogs");
// Config::set("default_404_method","index");

/* Directory Inside Contoller Directory */
Config::set("directory",['','admin','users','system']);

##Middleware Definitions
/* Set access rules to all sub Directory class */
$access_rule_to_admin_dir = function(){
	$login_args = ['redirect'=> url('admin') ,'msg'=> str('access_denied')];
	// pa( M5\Library\Session::get() ,1);
	$redirect_again_to = $_SERVER['REQUEST_URI'];
	M5\Library\Auth::isLogined($login_args,$redirect_again_to) ;
};

$access_rule_to_users_dir = function(){
	$login_user_args = ['redirect'=> url() ,'msg'=> str('access_denied'), "session" => "login"];
	// Session::get();
	// pa( M5\Library\Session::get() ,1);
	$redirect_again_to = $_SERVER['REQUEST_URI'];
	M5\Library\Auth::isLogined($login_user_args,$redirect_again_to) ;
};

$access_rule_to_system_dir = function(){
	$dev = strtolower( DEV_MODE );
	if($dev != "on"){
		die(" SET define('DEV_MODE', 'on')");
	}
};

/* 1. Specified  directory[] name */
/* 2. Specified  rules [][]*/
/* 3. Config::set("directory",['','admin','users','system']); */

$rules=
[

"directories" =>
['system', 'admin','users'],

"rules" =>
[
"system" =>  ["omitted_class"=>['index'], "access_rule"=>$access_rule_to_system_dir ],
"admin"  =>  ["omitted_class"=>['index'], "access_rule"=>$access_rule_to_admin_dir ] ,
"users"  =>  ["omitted_class"=>['index'], "access_rule"=>$access_rule_to_users_dir ],
]

];

Config::set("RouterAccessRules",$rules);


/* APP Default Specializations */
Config::set("salt","787434kl76lk7");
Config::set("default_language","ar");

Config::set("default_controller","index");
Config::set("default_method","index");

Config::set("default_view_prefix","");
Config::set("default_widgets_prefix","widgets");


define("_WID",Config::get("V_PATH").Config::get("default_widgets_prefix").'/');