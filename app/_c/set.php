<?php 	namespace M5\Controllers;

use M5\MVC\App;
use M5\MVC\Controller as BaseController;

use M5\MVC\Config;
use M5\Library\Page;
use M5\Library\Session;
use M5\Library\Hash;
use M5\Library\Schema;

/*use M5\Models\set_model;*/
use M5\MVC\Model;

class Set
{
	private $class_label = "setup";

	function __construct()
	{
	}



	/** * Main Function */
	public function index(){

		$this->setup();
	}

	/* Sql Injection DB */
	private function setup(){
		$db = Model::getInst();

	#users
		if($db->query("
			CREATE TABLE IF NOT EXISTS `users` (
			`ID` INT PRIMARY KEY AUTO_INCREMENT,
			`BETA` VARCHAR(64),
			`is_admin` TINYINT  default 0 ,
			`name` VARCHAR( 225 ) ,
			`user` VARCHAR( 225 ) ,
			`pass` VARCHAR( 225 ) ,
			`email` VARCHAR( 225 ) ,
			`tel` VARCHAR( 225 ) ,
			`country` VARCHAR( 225 ) ,
			`ip` VARCHAR( 225 ) ,
			`about` VARCHAR( 225 ) ,
			`c_at` VARCHAR(20),
			`u_at` VARCHAR(20) ,
			`st`  INT
			)"))
			echo '<div># users created<br /></div>'; else echo '<div>(!) users table error : '.$db->error().' ;<br /></div>';

		$seed_args = ["name"=>site_name, "user"=>"admin", "is_admin"=>1, "pass"=> Hash::MD5("1234")];

		/* INSERT DEFAULT ROOT USER */
		$cond = " && ( user = 'admin' )";
		$r_admin = $db->table(['tbl'=>"users"])->where($cond)->fetch(['printQuery'=>0, 'index'=>'first']);

		!$r_admin  ? $db->insert($seed_args,"users") : '' ;

	#role lists
		if($db->query("CREATE TABLE IF NOT EXISTS roles(
			ID INT AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(20) ,
			alias VARCHAR(100)
			)")
			)
			echo "<div># Roles table created!</div>";
		else
			echo "<div>!) Roles table error : ".$db->error()."</div>";

	#passport to users
		if($db->query("CREATE TABLE IF NOT EXISTS passport(
			ID INT AUTO_INCREMENT PRIMARY KEY,
			admin_id VARCHAR(20) ,
			role_id VARCHAR(20)
			)")
			)
			echo "<div># passport table created!</div>";
		else
			echo "<div>!) passport table error : ".$db->error()."</div>";


	#Tree categories
		if($db->query("
			CREATE TABLE IF NOT EXISTS tree(
			ID int AUTO_INCREMENT PRIMARY key,
			type varchar(100) DEFAULT 'part',
			name varchar(200),
			_desc longtext,
			rank varchar(100) default 'parent' ,
			parent varchar(100) default '0',
			ava varchar(100),
			st int DEFAULT 1,
			BETA varchar(32),
			`c_at` VARCHAR( 100 ),
			`u_at` VARCHAR( 100 )

			)"))

			echo '<div># Tree created<br /></div>'; else echo '<div>(!) Tree table error : '.$db->error().' ;<br /></div>';

        #Records categories
		if($db->query("
			CREATE TABLE IF NOT EXISTS records(
			ID int AUTO_INCREMENT PRIMARY key,
			BETA varchar(64),

			`name`     VARCHAR(225),

			`user_id` VARCHAR( 100 ),
			`c_at`    VARCHAR( 100 ),
			`u_at`    VARCHAR( 100 )

			)"))

			echo '<div># Records created<br /></div>'; else echo '<div>(!) Records table error : '.$db->error().' ;<br /></div>';


	# MIC-applicaiotn information
		if( $db->query("
			CREATE TABLE  IF NOT EXISTS mic(
			`ID`  INT PRIMARY KEY AUTO_INCREMENT,
			`name`  varchar(200) ,
			`description`   longtext ,
			`keywords`  longtext ,
			`email`  varchar(200) ,
			`tel`  varchar(200) ,
			`notes` LONGTEXT ,
			`c_at` varchar(200) ,
			`u_at` varchar(200) ,
			st INT default 1
			) "))
			echo '<div># mic created<br /></div>'; else echo '<div>(!) mic table error : '.$db->error().' ;<br /></div>';

		$mic_args = [
		"name" => "MAKE BY MIC",
		"description" => Config::get("site_name"). "\n". Config::get("site"),
		"keywords" => Config::get("site_name"),
		"email" => "info@".Config::get("HOST"),
		"tel" => "",
		];

		/* Insert default Applicaiotn info*/
		$sql = " SELECT * FROM mic WHERE 1 ";

		if( !$db->query( $sql )->num_rows ){
			$db->insert($mic_args,"mic",0);
		}

	#vistors of website
		$audience = $db->query("
			CREATE TABLE  IF NOT EXISTS   `audience` (
			`id` int(11)  auto_increment,
			`ip` varchar(225) ,
			`country` varchar(225) ,
			`r_time` varchar(100) ,
			`r_date` varchar(100) ,
			PRIMARY KEY  (`id`)
			)
			");
		if($audience) echo '<div># audience created<br /></div>'; else echo '<div>(!) audience table error : '.$db->error().' ;<br /></div>';


		#Notifications
		$notifications= $db->query("
			CREATE TABLE IF NOT EXISTS  `notifications` (
			`id` INT  AUTO_INCREMENT PRIMARY KEY ,
			`type` VARCHAR( 100 )  ,
			`user_id` VARCHAR(20)  ,
			`notifications` LONGTEXT  ,
			`url` VARCHAR( 225 )  ,
			`c_at` VARCHAR( 225 ) ,
			`u_at` VARCHAR( 225 ) ,
			`st` INT
			)
			");
		if($notifications) echo '<div> # notifications  created!</div>'; else echo "<div> ! notifications table error : ".$db->error()."</div>";


 	#pages
		if($db->query("
			CREATE TABLE IF NOT EXISTS `pages` (
			`ID`        INT PRIMARY KEY AUTO_INCREMENT,
			`BETA`      VARCHAR(64),
			`part_id`   VARCHAR (20) default 1,
			`child_id`  VARCHAR (20) ,

			`type`      varchar(100) default 'page',
			`name`      varchar(225) ,
			`slug`      varchar(225) NOT NULL ,
			`content`   LONGTEXT,
			`tags`      MEDIUMTEXT,
			`v`         INT,

			`user_id`   VARCHAR(64),
			`c_at`      varchar(20) ,
			`u_at`      varchar(20) ,
			st INT      default 1
			) "))

			echo '<div># pages created<br /></div>'; else echo '<div>(!) pages table error : '.$db->error().' ;<br /></div>';


	#preferences
		if ( $db->query("
			CREATE TABLE IF NOT EXISTS `preferences` (
			`ID` INT  PRIMARY KEY AUTO_INCREMENT ,
			`key` VARCHAR(200)  ,
			`value` LONGTEXT  ,
			`c_at` VARCHAR(30)  ,
			`st` INT  )
			")
			) {
			echo "<div># preferences table created!</div>";
	} else {
		echo "<div>#preferences table error: " . $db->error() . "</div>";
	}

	#types
	if ( $db->query("
		CREATE TABLE IF NOT EXISTS `types` (
		`ID` INT  PRIMARY KEY AUTO_INCREMENT ,
		`name` VARCHAR(200)  ,
		`type` VARCHAR(200)  ,
		`content` LONGTEXT  ,
		`content2` LONGTEXT  ,
		`content3` LONGTEXT  ,
		`content4` LONGTEXT  ,
		`content5` LONGTEXT  ,
		`ava` VARCHAR(200)  ,
		`c_at` VARCHAR(30)  ,
		`u_at` VARCHAR(30)  ,
		`st` INT  )
		")
		) {
		echo "<div># types table created!</div>";
} else {
	echo "<div>#types table error: " . $db->error() . "</div>";
}


	#Blogs
if($db->query("
	CREATE TABLE IF NOT EXISTS  `blogs` (
	`ID`       INT  AUTO_INCREMENT PRIMARY KEY ,
	`BETA`     VARCHAR( 225 )  ,
	`part_id`  VARCHAR(100)  ,
	`child_id` VARCHAR(100)  ,
	`user_id`  VARCHAR( 225 )  ,
	`name`     VARCHAR( 225 )  ,
	`content`  LONGTEXT  ,
	`v`        INT  ,
	`c_at`     VARCHAR( 100 )  ,
	`u_at`     VARCHAR( 100 )  ,
	`e_at`     VARCHAR( 100 )  ,
	`st`       INT ,
	tags       TEXT,
	notes       TEXT
	) ")
	)
{
	echo '<div># blogs blog table created!</div>';
} else {
	echo '<div> (!) blogs blog table  error :' . $db->error() . '</div>';
}


echo "<hr>";
echo "<a href = ".url()." > Home </a> | ";
echo "<a href = ".url('admin')." > Admin </a>";
}


}